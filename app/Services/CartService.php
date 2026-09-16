<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected string $sessionKey = 'fortunes_cart';

    /**
     * Retrieve all cart items with fresh product & variant data from DB.
     */
    public function getCart(): array
    {
        $rawCart = Session::get($this->sessionKey, []);
        $items = [];
        $subtotal = 0;
        $totalQuantity = 0;

        foreach ($rawCart as $key => $item) {
            $product = Product::with(['primaryImage', 'category'])->find($item['product_id']);

            if (!$product || $product->status !== 'active') {
                $this->removeItem($key);
                continue;
            }

            $variant = null;
            $unitPrice = (float) $product->price;
            $stockAvailable = $product->total_stock;
            $variantDetails = null;

            if (!empty($item['variant_id'])) {
                $variant = ProductVariant::find($item['variant_id']);
                if ($variant && $variant->product_id === $product->id) {
                    $unitPrice = $variant->effective_price;
                    $stockAvailable = $variant->stock_quantity;
                    $variantDetails = "Size: {$variant->size}" . ($variant->color ? " | Color: {$variant->color}" : "");
                }
            }

            // Cap requested quantity to actual available stock
            $quantity = max(1, min((int) $item['quantity'], max(1, $stockAvailable)));
            $itemSubtotal = $unitPrice * $quantity;
            $subtotal += $itemSubtotal;
            $totalQuantity += $quantity;

            $items[$key] = [
                'key' => $key,
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'product' => $product,
                'variant' => $variant,
                'name' => $product->name,
                'subtitle' => $product->subtitle,
                'sku' => $variant ? $variant->sku : $product->sku,
                'variant_details' => $variantDetails,
                'image' => $product->featured_image,
                'unit_price' => $unitPrice,
                'formatted_price' => '₦' . number_format($unitPrice, 0),
                'quantity' => $quantity,
                'subtotal' => $itemSubtotal,
                'formatted_subtotal' => '₦' . number_format($itemSubtotal, 0),
                'stock_available' => $stockAvailable,
                'is_sold_out' => $stockAvailable <= 0,
            ];
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'formatted_subtotal' => '₦' . number_format($subtotal, 0),
            'total_quantity' => $totalQuantity,
            'free_shipping_threshold' => 500000,
            'free_shipping_qualified' => $subtotal >= 500000,
            'amount_needed_for_free_shipping' => max(0, 500000 - $subtotal),
            'formatted_amount_needed' => '₦' . number_format(max(0, 500000 - $subtotal), 0),
            'free_shipping_progress' => min(100, round(($subtotal / 500000) * 100)),
        ];
    }

    /**
     * Add product or variant to cart with server-side validation.
     */
    public function addItem(int $productId, ?int $variantId = null, int $quantity = 1): array
    {
        $product = Product::findOrFail($productId);
        $stock = $product->total_stock;

        if ($variantId) {
            $variant = ProductVariant::where('product_id', $productId)->findOrFail($variantId);
            $stock = $variant->stock_quantity;
        }

        if ($stock <= 0) {
            return [
                'success' => false,
                'message' => 'This luxury item is currently sold out in our archive.',
            ];
        }

        $cart = Session::get($this->sessionKey, []);
        $itemKey = $productId . '_' . ($variantId ?? '0');

        $currentQty = isset($cart[$itemKey]) ? (int) $cart[$itemKey]['quantity'] : 0;
        $newQty = min($stock, $currentQty + max(1, $quantity));

        $cart[$itemKey] = [
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity' => $newQty,
        ];

        Session::put($this->sessionKey, $cart);

        return [
            'success' => true,
            'message' => 'Added to your Fortunes bag.',
            'cart' => $this->getCart(),
        ];
    }

    /**
     * Update quantity of an item in the cart.
     */
    public function updateQuantity(string $itemKey, int $quantity): array
    {
        $cart = Session::get($this->sessionKey, []);

        if (!isset($cart[$itemKey])) {
            return ['success' => false, 'message' => 'Item not found in bag.'];
        }

        if ($quantity <= 0) {
            return $this->removeItem($itemKey);
        }

        $item = $cart[$itemKey];
        $maxStock = 99;

        if (!empty($item['variant_id'])) {
            $variant = ProductVariant::find($item['variant_id']);
            if ($variant) {
                $maxStock = $variant->stock_quantity;
            }
        } else {
            $product = Product::find($item['product_id']);
            if ($product) {
                $maxStock = $product->total_stock;
            }
        }

        $cart[$itemKey]['quantity'] = min($maxStock, $quantity);
        Session::put($this->sessionKey, $cart);

        return [
            'success' => true,
            'cart' => $this->getCart(),
        ];
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(string $itemKey): array
    {
        $cart = Session::get($this->sessionKey, []);
        unset($cart[$itemKey]);
        Session::put($this->sessionKey, $cart);

        return [
            'success' => true,
            'message' => 'Item removed from bag.',
            'cart' => $this->getCart(),
        ];
    }

    /**
     * Clear entire cart.
     */
    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }
}
