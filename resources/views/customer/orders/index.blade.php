@extends('layouts.app')

@section('title', 'MY ARCHIVE ORDERS | Fortunes Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <div class="flex items-center justify-between border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-4">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-widest mb-1">
                <a href="{{ route('customer.dashboard') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">Dashboard</a>
                <span>/</span>
                <span class="text-[#9E7D36] dark:text-[#D4AF37] font-bold">Orders</span>
            </div>
            <h1 class="font-serif text-3xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">ACQUISITION HISTORY</h1>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="p-16 text-center bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-3 shadow-sm">
            <p class="font-serif text-xl text-neutral-900 dark:text-white">No orders placed yet.</p>
            <a href="{{ route('shop.catalog') }}" class="inline-block mt-2 px-6 py-2.5 btn-gold text-xs font-bold tracking-widest">
                DISCOVER THE ARCHIVE
            </a>
        </div>
    @else
        <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden divide-y divide-neutral-200 dark:divide-neutral-800 shadow-sm">
            @foreach($orders as $order)
                <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-6 font-mono text-xs">
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-neutral-900 dark:text-white text-base">{{ $order->order_number }}</span>
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase border {{ $order->status_badge_class }}">
                                {{ $order->status }}
                            </span>
                        </div>
                        <p class="text-neutral-600 dark:text-neutral-400">{{ $order->created_at->format('M d, Y') }} ⬝ {{ $order->shipping_method }}</p>
                        <div class="flex items-center gap-2 pt-1">
                            @foreach($order->items->take(3) as $item)
                                <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                     class="w-8 h-10 object-cover rounded border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800" title="{{ $item->product_name }}">
                            @endforeach
                            @if($order->items->count() > 3)
                                <span class="text-neutral-500 text-[10px]">+{{ $order->items->count() - 3 }} more</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-between md:justify-end gap-6">
                        <div class="text-right">
                            <span class="font-serif text-xl font-bold text-[#9E7D36] dark:text-[#D4AF37] block">{{ $order->formatted_total }}</span>
                            <span class="text-[10px] text-neutral-500 uppercase">{{ $order->payment_method }}</span>
                        </div>
                        <a href="{{ route('customer.orders.show', $order->order_number) }}"
                           class="px-4 py-2.5 btn-outline-gold text-xs font-mono font-bold tracking-wider rounded">
                            View Order
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection
