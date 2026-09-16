<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items.product')->take(5)->get();
        $totalSpent = $user->orders()->where('status', 'paid')->sum('total_amount');
        $addressesCount = $user->addresses()->count();

        return view('customer.dashboard', compact('user', 'orders', 'totalSpent', 'addressesCount'));
    }

    public function orders(): View
    {
        $orders = Auth::user()->orders()->with(['items.product', 'shippingAddress'])->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function orderDetail(string $orderNumber): View
    {
        $user = Auth::user();
        $order = Order::with(['items.product', 'shippingAddress', 'payments'])
            ->where('order_number', $orderNumber)
            ->where('user_id', $user->id) // Strict server-side customer isolation
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    public function addresses(): View
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('customer.addresses.index', compact('addresses'));
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'lga' => 'nullable|string|max:100',
            'delivery_instructions' => 'nullable|string|max:500',
            'is_default' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        if (!empty($validated['is_default'])) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create([
            'recipient_name' => $validated['recipient_name'],
            'email' => $user->email,
            'phone' => $validated['phone'],
            'street_address' => $validated['street_address'],
            'apartment' => $validated['apartment'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'lga' => $validated['lga'] ?? null,
            'delivery_instructions' => $validated['delivery_instructions'] ?? null,
            'is_default' => !empty($validated['is_default']),
        ]);

        return redirect()->route('customer.addresses')->with('success', 'Address saved to your address book.');
    }
}
