<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    protected function getOrCreateWishlist(): Wishlist
    {
        $user = Auth::user();
        if ($user) {
            return Wishlist::firstOrCreate(['user_id' => $user->id]);
        }

        $sessionId = Session::getId();
        return Wishlist::firstOrCreate(['session_id' => $sessionId]);
    }

    public function index(): View
    {
        $wishlist = $this->getOrCreateWishlist();
        $items = $wishlist->items()->with('product.primaryImage', 'product.category')->get();

        return view('customer.wishlist.index', compact('items'));
    }

    public function toggle(Request $request): JsonResponse|RedirectResponse
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);
        $wishlist = $this->getOrCreateWishlist();

        $existing = WishlistItem::where('wishlist_id', $wishlist->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $inWishlist = false;
            $message = 'Removed from your archive wishlist.';
        } else {
            WishlistItem::create([
                'wishlist_id' => $wishlist->id,
                'product_id' => $product->id,
            ]);
            $inWishlist = true;
            $message = 'Saved to your archive wishlist.';
        }

        $totalCount = $wishlist->items()->count();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'in_wishlist' => $inWishlist,
                'total_count' => $totalCount,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
