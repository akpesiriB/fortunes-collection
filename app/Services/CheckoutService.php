<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Address;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutService
{
    /**
     * Shipping rates based on Nigerian regions and methods.
     */
    public const SHIPPING_METHODS = [
        'effurun_vip' => [
            'name' => 'Effurun Atelier Same-Day VIP Dispatch',
            'fee' => 2500.00,
            'time' => 'Same-Day (Under 4 Hours)',
        ],
        'delta_express' => [
            'name' => 'Delta State Regional Express (Warri, Asaba, Sapele)',
            'fee' => 3500.00,
            'time' => '24 Hours',
        ],
        'nationwide_express' => [
            'name' => 'Nationwide Priority Air Courier (Abuja, Port Harcourt, Benin, Ibadan)',
            'fee' => 7500.00,
            'time' => '2 - 3 Business Days',
        ],
        'international_dhl' => [
            'name' => 'International DHL Express (UK, US, Canada, Europe)',
            'fee' => 45000.00,
            'time' => '3 - 5 Business Days',
        ],
    ];

    public function getShippingFee(string $methodKey, float $subtotal): float
    {
        // Complimentary shipping on orders >= ₦500,000 within Nigeria
        if ($subtotal >= 500000 && in_array($methodKey, ['effurun_vip', 'delta_express', 'nationwide_express'])) {
            return 0.0;
        }

        if (isset(self::SHIPPING_METHODS[$methodKey])) {
            return (float) self::SHIPPING_METHODS[$methodKey]['fee'];
        }

        return 3500.00; // Default
    }

    public function validateCoupon(?string $code, float $subtotal): array
    {
        if (empty($code)) {
            return ['valid' => false, 'discount' => 0.0, 'coupon' => null, 'message' => null];
        }

        $coupon = Coupon::where('code', strtoupper(trim($code)))->first();

        if (!$coupon) {
            return ['valid' => false, 'discount' => 0.0, 'coupon' => null, 'message' => 'Invalid promo code.'];
        }

        if (!$coupon->isValidForAmount($subtotal)) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'coupon' => $coupon,
                'message' => "Order minimum of ₦" . number_format($coupon->min_spend, 0) . " required for this code.",
            ];
        }

        $discount = $coupon->calculateDiscount($subtotal);

        return [
            'valid' => true,
            'discount' => $discount,
            'coupon' => $coupon,
            'message' => "Promo code applied successfully (-₦" . number_format($discount, 0) . ")",
        ];
    }

    public function calculateTotals(array $cart, string $shippingMethod, ?string $couponCode = null): array
    {
        $subtotal = (float) $cart['subtotal'];
        $shippingFee = $this->getShippingFee($shippingMethod, $subtotal);
        $couponResult = $this->validateCoupon($couponCode, $subtotal);
        $discountAmount = $couponResult['valid'] ? $couponResult['discount'] : 0.0;

        $totalAmount = max(0, ($subtotal - $discountAmount) + $shippingFee);

        return [
            'subtotal' => $subtotal,
            'formatted_subtotal' => '₦' . number_format($subtotal, 0),
            'shipping_method' => $shippingMethod,
            'shipping_fee' => $shippingFee,
            'formatted_shipping_fee' => $shippingFee > 0 ? '₦' . number_format($shippingFee, 0) : 'COMPLIMENTARY',
            'coupon_code' => $couponResult['valid'] ? $couponResult['coupon']->code : null,
            'discount_amount' => $discountAmount,
            'formatted_discount' => $discountAmount > 0 ? '-₦' . number_format($discountAmount, 0) : '₦0',
            'total_amount' => $totalAmount,
            'formatted_total' => '₦' . number_format($totalAmount, 0),
            'coupon_result' => $couponResult,
        ];
    }

    /**
     * Create a pending order with strict atomic server-side recalculation.
     */
    public function createPendingOrder(array $customerData, array $cart, array $totals): Order
    {
        return DB::transaction(function () use ($customerData, $cart, $totals) {
            $user = Auth::user();

            // 1. Create or link shipping address
            $address = Address::create([
                'user_id' => $user?->id,
                'recipient_name' => $customerData['name'],
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
                'street_address' => $customerData['street_address'],
                'apartment' => $customerData['apartment'] ?? null,
                'city' => $customerData['city'],
                'state' => $customerData['state'],
                'lga' => $customerData['lga'] ?? null,
                'country' => 'Nigeria',
                'delivery_instructions' => $customerData['notes'] ?? null,
            ]);

            // 2. Create the Order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user?->id,
                'customer_name' => $customerData['name'],
                'customer_email' => $customerData['email'],
                'customer_phone' => $customerData['phone'],
                'shipping_address_id' => $address->id,
                'shipping_method' => $totals['shipping_method'],
                'status' => 'pending',
                'currency' => 'NGN',
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $totals['discount_amount'],
                'shipping_fee' => $totals['shipping_fee'],
                'tax_amount' => 0.00,
                'total_amount' => $totals['total_amount'],
                'coupon_code' => $totals['coupon_code'],
                'payment_method' => $customerData['payment_method'] ?? 'paystack',
                'payment_status' => 'unpaid',
                'customer_notes' => $customerData['notes'] ?? null,
            ]);

            // 3. Create Order Items & Reserve Inventory
            foreach ($cart['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'product_name' => $item['name'],
                    'product_sku' => $item['sku'],
                    'variant_details' => $item['variant_details'],
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'product_image' => $item['image'],
                ]);

                // Atomically update inventory reservation
                if (!empty($item['variant_id'])) {
                    Inventory::where('product_variant_id', $item['variant_id'])
                        ->increment('reserved_count', $item['quantity']);
                }
            }

            // Record coupon usage if applied
            if (!empty($totals['coupon_code'])) {
                $coupon = Coupon::where('code', $totals['coupon_code'])->first();
                if ($coupon) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'order_id' => $order->id,
                        'user_id' => $user?->id,
                        'discount_amount' => $totals['discount_amount'],
                    ]);
                    $coupon->increment('used_count');
                }
            }

            return $order;
        });
    }
}
