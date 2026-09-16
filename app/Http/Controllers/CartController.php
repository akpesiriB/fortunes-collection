<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(): View
    {
        $cart = $this->cartService->getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $result = $this->cartService->addItem(
            (int) $request->input('product_id'),
            $request->input('variant_id') ? (int) $request->input('variant_id') : null,
            (int) $request->input('quantity', 1)
        );

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'item_key' => 'required|string',
            'quantity' => 'required|integer|min:0',
        ]);

        $result = $this->cartService->updateQuantity(
            $request->input('item_key'),
            (int) $request->input('quantity')
        );

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->back()->with('success', 'Bag updated.');
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'item_key' => 'required|string',
        ]);

        $result = $this->cartService->removeItem($request->input('item_key'));

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return redirect()->back()->with('success', $result['message']);
    }

    public function data(): JsonResponse
    {
        return response()->json($this->cartService->getCart());
    }
}
