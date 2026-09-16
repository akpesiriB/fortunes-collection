@extends('layouts.admin')

@section('title', 'COMMAND OVERVIEW | Fortunes Collection')
@section('page_title', 'Executive Overview')

@section('content')
<div class="space-y-8">
    
    <!-- Top Executive KPI Matrix -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Revenue -->
        <div class="bg-[#121212] border border-[#D4AF37]/40 rounded-2xl p-6 space-y-2 relative overflow-hidden shadow-xl">
            <div class="flex justify-between items-start">
                <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest">Total Archive Revenue</span>
                <span class="w-8 h-8 rounded-full bg-[#1C1C1C] border border-[#D4AF37]/30 flex items-center justify-center text-[#D4AF37] text-sm">₦</span>
            </div>
            <p class="font-serif text-3xl font-bold text-white tracking-tight">₦{{ number_format($totalRevenue, 0) }}</p>
            <span class="font-mono text-[10px] text-emerald-400 flex items-center gap-1">
                <span>↑</span>
                <span>Verified Paystack Payments</span>
            </span>
        </div>

        <!-- Total Orders -->
        <div class="bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-2 shadow-xl">
            <div class="flex justify-between items-start">
                <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest">Acquisition Volume</span>
                <span class="w-8 h-8 rounded-full bg-[#1C1C1C] border border-neutral-700 flex items-center justify-center text-white text-xs font-mono">📦</span>
            </div>
            <p class="font-serif text-3xl font-bold text-white tracking-tight">{{ $totalOrdersCount }} Orders</p>
            <span class="font-mono text-[10px] text-[#D4AF37]">{{ $paidOrdersCount }} Paid ⬝ {{ $pendingOrdersCount }} Pending</span>
        </div>

        <!-- Average Order Value -->
        <div class="bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-2 shadow-xl">
            <div class="flex justify-between items-start">
                <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest">Average Basket Value</span>
                <span class="w-8 h-8 rounded-full bg-[#1C1C1C] border border-neutral-700 flex items-center justify-center text-white text-xs font-mono">⚡</span>
            </div>
            <p class="font-serif text-3xl font-bold text-[#D4AF37] tracking-tight">₦{{ number_format($aov, 0) }}</p>
            <span class="font-mono text-[10px] text-neutral-400 uppercase tracking-wider">Per Paying Collector</span>
        </div>

        <!-- Registered Collectors -->
        <div class="bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-2 shadow-xl">
            <div class="flex justify-between items-start">
                <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest">Active Collectors</span>
                <span class="w-8 h-8 rounded-full bg-[#1C1C1C] border border-neutral-700 flex items-center justify-center text-white text-xs font-mono">👤</span>
            </div>
            <p class="font-serif text-3xl font-bold text-white tracking-tight">{{ $totalCustomersCount }}</p>
            <span class="font-mono text-[10px] text-neutral-400 uppercase tracking-wider">{{ $totalProductsCount }} Active Silhouettes</span>
        </div>
    </div>

    <!-- Low Stock Alert Banner (If Any) -->
    @if($lowStockItems->isNotEmpty())
        <div class="bg-amber-950/40 border border-amber-800/60 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full bg-amber-400 animate-ping"></span>
                    <h3 class="font-serif text-lg font-bold text-amber-300 uppercase tracking-wide">ATELIER LOW STOCK MATRIX</h3>
                </div>
                <a href="{{ route('admin.inventory.index') }}" class="font-mono text-xs text-amber-300 hover:underline uppercase tracking-wider">Manage Matrix →</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 font-mono text-xs">
                @foreach($lowStockItems as $inv)
                    <div class="p-3 bg-[#121212] border border-amber-800/40 rounded-lg flex items-center justify-between">
                        <div>
                            <p class="text-white font-bold truncate">{{ $inv->product->name }}</p>
                            <span class="text-neutral-400 text-[10px]">{{ $inv->variant?->size }} / {{ $inv->variant?->color }}</span>
                        </div>
                        <span class="px-2 py-1 rounded {{ $inv->stock_count <= 0 ? 'bg-red-950 text-red-400 border border-red-800' : 'bg-amber-900/60 text-amber-300 border border-amber-700' }} font-bold text-[11px]">
                            {{ $inv->stock_count }} Left
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Recent Orders & Best Sellers Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Recent Orders (8 Cols) -->
        <div class="lg:col-span-8 bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-4 shadow-xl">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="font-serif text-lg font-bold uppercase text-white tracking-wide">RECENT ACQUISITIONS</h3>
                <a href="{{ route('admin.orders.index') }}" class="font-mono text-xs text-[#D4AF37] hover:underline uppercase tracking-wider">All Orders →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left font-mono text-xs">
                    <thead>
                        <tr class="border-b border-neutral-800 text-neutral-400 uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-2">Order #</th>
                            <th class="py-3 px-2">Collector</th>
                            <th class="py-3 px-2">Amount</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2">Date</th>
                            <th class="py-3 px-2 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-neutral-800/40 transition-colors">
                                <td class="py-3 px-2 font-bold text-white">{{ $order->order_number }}</td>
                                <td class="py-3 px-2">
                                    <span class="text-white block">{{ $order->customer_name }}</span>
                                    <span class="text-neutral-500 text-[10px]">{{ $order->customer_phone }}</span>
                                </td>
                                <td class="py-3 px-2 font-bold text-[#D4AF37]">{{ $order->formatted_total }}</td>
                                <td class="py-3 px-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold border {{ $order->status_badge_class }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-neutral-400 text-[11px]">{{ $order->created_at->format('M d, H:i') }}</td>
                                <td class="py-3 px-2 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-[#D4AF37] hover:underline">Inspect →</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Best Sellers & Quick Launch (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Best Sellers Card -->
            <div class="bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-4 shadow-xl">
                <h3 class="font-serif text-lg font-bold uppercase text-white tracking-wide border-b border-neutral-800 pb-3">
                    HAUTE BEST SELLERS
                </h3>
                <div class="space-y-3 font-mono text-xs">
                    @foreach($bestSellers as $b)
                        <div class="flex items-center gap-3 p-2 bg-[#181818] rounded-lg border border-neutral-800">
                            <img src="{{ $b->featured_image }}" alt="{{ $b->name }}" class="w-12 h-14 object-cover rounded bg-neutral-900 border border-neutral-700">
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-bold truncate uppercase font-serif text-sm">{{ $b->name }}</p>
                                <span class="text-[#D4AF37] text-[11px] block">{{ $b->formatted_price }}</span>
                                <span class="text-neutral-500 text-[10px]">{{ $b->total_stock }} in archive</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Quick Navigation Commands -->
            <div class="bg-[#121212] border border-[#D4AF37]/30 rounded-2xl p-6 space-y-3 font-mono text-xs">
                <h4 class="font-serif text-base font-bold uppercase text-white">DIRECT ACTIONS</h4>
                <a href="{{ route('admin.products.create') }}" class="block w-full text-center py-3 btn-gold text-xs font-bold uppercase rounded-lg shadow">
                    + Add New Silhouette
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="block w-full text-center py-2.5 border border-neutral-700 hover:border-neutral-500 text-neutral-300 rounded uppercase">
                    Pending Dispatches
                </a>
                <a href="{{ route('admin.content.index') }}" class="block w-full text-center py-2.5 border border-neutral-700 hover:border-neutral-500 text-neutral-300 rounded uppercase">
                    Update Maison Ticker
                </a>
                <a href="{{ route('admin.database') }}" target="_blank" class="block w-full text-center py-2.5 border border-[#D4AF37]/50 hover:border-[#D4AF37] bg-[#D4AF37]/10 hover:bg-[#D4AF37]/20 text-[#D4AF37] font-bold rounded uppercase transition-colors">
                    🗄️ Launch phpMyAdmin
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
