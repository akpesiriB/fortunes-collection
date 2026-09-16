<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Payment;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalRevenue = Order::where('status', 'paid')->sum('total_amount');
        $totalOrdersCount = Order::count();
        $paidOrdersCount = Order::where('status', 'paid')->count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $totalCustomersCount = User::count();
        $totalProductsCount = Product::count();

        // Average order value
        $aov = $paidOrdersCount > 0 ? ($totalRevenue / $paidOrdersCount) : 0;

        // Low stock alerts
        $lowStockItems = Inventory::with(['product', 'variant'])
            ->whereRaw('stock_count <= low_stock_threshold')
            ->orderBy('stock_count', 'asc')
            ->take(6)
            ->get();

        // Recent Orders
        $recentOrders = Order::with(['items', 'shippingAddress'])
            ->latest()
            ->take(8)
            ->get();

        // Recent Payments
        $recentPayments = Payment::with('order')
            ->latest()
            ->take(5)
            ->get();

        // Top Selling Products
        $bestSellers = Product::with(['category', 'primaryImage'])
            ->where('is_bestseller', true)
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrdersCount',
            'paidOrdersCount',
            'pendingOrdersCount',
            'totalCustomersCount',
            'totalProductsCount',
            'aov',
            'lowStockItems',
            'recentOrders',
            'recentPayments',
            'bestSellers'
        ));
    }
}
