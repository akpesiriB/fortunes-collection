<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['items.product', 'shippingAddress', 'payments']);

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $s = $request->query('search');
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'like', "%{$s}%")
                  ->orWhere('customer_name', 'like', "%{$s}%")
                  ->orWhere('customer_email', 'like', "%{$s}%")
                  ->orWhere('customer_phone', 'like', "%{$s}%");
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'shippingAddress', 'payments', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:100',
            'courier_name' => 'nullable|string|max:100',
            'internal_notes' => 'nullable|string|max:1000',
        ]);

        $orderData = [
            'status' => $validated['status'],
            'tracking_number' => $validated['tracking_number'] ?? $order->tracking_number,
            'courier_name' => $validated['courier_name'] ?? $order->courier_name,
            'internal_notes' => $validated['internal_notes'] ?? $order->internal_notes,
        ];

        if ($validated['status'] === 'shipped' && !$order->shipped_at) {
            $orderData['shipped_at'] = now();
        }

        if ($validated['status'] === 'delivered' && !$order->delivered_at) {
            $orderData['delivered_at'] = now();
        }

        if ($validated['status'] === 'paid' && !$order->paid_at) {
            $orderData['paid_at'] = now();
            $orderData['payment_status'] = 'paid';
        }

        $order->update($orderData);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }
}
