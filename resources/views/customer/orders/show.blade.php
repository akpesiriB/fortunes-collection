@extends('layouts.app')

@section('title', 'ORDER ' . $order->order_number . ' | Fortunes Collection')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-4 gap-4">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-widest mb-1">
                <a href="{{ route('customer.orders') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">Orders</a>
                <span>/</span>
                <span class="text-[#9E7D36] dark:text-[#D4AF37] font-bold">{{ $order->order_number }}</span>
            </div>
            <h1 class="font-serif text-3xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">ORDER DETAILS</h1>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded text-xs font-mono font-bold uppercase border {{ $order->status_badge_class }}">
                Status: {{ $order->status }}
            </span>
            <button onclick="window.print()" class="px-3 py-1 border border-neutral-300 dark:border-neutral-700 hover:border-neutral-500 rounded text-xs font-mono uppercase text-neutral-700 dark:text-neutral-300 hover:text-black dark:hover:text-white transition-colors">
                Print
            </button>
        </div>
    </div>

    <!-- Items list -->
    <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 space-y-4 shadow-sm">
        <h3 class="font-serif text-lg font-bold uppercase text-neutral-900 dark:text-white">RESERVED SILHOUETTES</h3>
        <div class="divide-y divide-neutral-200 dark:divide-neutral-800 font-mono text-xs">
            @foreach($order->items as $item)
                <div class="py-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                             class="w-16 h-20 object-cover rounded bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                        <div>
                            <span class="text-[10px] text-[#9E7D36] dark:text-[#D4AF37] uppercase font-bold">{{ $item->product_sku }}</span>
                            <h4 class="font-serif text-base font-bold text-neutral-900 dark:text-white uppercase">{{ $item->product_name }}</h4>
                            <p class="text-neutral-500 dark:text-neutral-400 text-[11px]">{{ $item->variant_details }}</p>
                            <span class="text-neutral-500 text-[11px]">Qty: {{ $item->quantity }} × {{ $item->formatted_unit_price }}</span>
                        </div>
                    </div>
                    <span class="font-bold text-neutral-900 dark:text-white text-sm">{{ $item->formatted_subtotal }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-mono text-xs">
        <div class="p-6 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-3 shadow-sm">
            <h4 class="font-serif text-base font-bold uppercase text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-800 pb-2">DELIVERY ADDRESS</h4>
            <p class="text-neutral-900 dark:text-white font-semibold">{{ $order->customer_name }}</p>
            <p class="text-neutral-600 dark:text-neutral-400">{{ $order->shippingAddress?->street_address }}</p>
            @if($order->shippingAddress?->apartment)
                <p class="text-neutral-600 dark:text-neutral-400">{{ $order->shippingAddress->apartment }}</p>
            @endif
            <p class="text-neutral-600 dark:text-neutral-400">{{ $order->shippingAddress?->city }}, {{ $order->shippingAddress?->state }}</p>
            <p class="text-neutral-600 dark:text-neutral-400">{{ $order->customer_phone }}</p>
            @if($order->tracking_number)
                <div class="pt-2 border-t border-neutral-200 dark:border-neutral-800 text-[#9E7D36] dark:text-[#D4AF37]">
                    <span class="block text-[10px] uppercase font-bold">Courier Tracking Number:</span>
                    <span class="font-bold">{{ $order->tracking_number }} ({{ $order->courier_name }})</span>
                </div>
            @endif
        </div>

        <div class="p-6 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-3 shadow-sm">
            <h4 class="font-serif text-base font-bold uppercase text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-800 pb-2">PAYMENT SUMMARY</h4>
            <div class="flex justify-between text-neutral-600 dark:text-neutral-400">
                <span>Subtotal:</span>
                <span class="text-neutral-900 dark:text-white font-semibold">{{ $order->formatted_subtotal }}</span>
            </div>
            <div class="flex justify-between text-neutral-600 dark:text-neutral-400">
                <span>Shipping:</span>
                <span class="text-[#9E7D36] dark:text-[#D4AF37] font-semibold">{{ $order->formatted_shipping_fee }}</span>
            </div>
            @if($order->discount_amount > 0)
                <div class="flex justify-between text-emerald-600 dark:text-emerald-400">
                    <span>Discount:</span>
                    <span>{{ $order->formatted_discount }}</span>
                </div>
            @endif
            <div class="flex justify-between text-base font-bold text-neutral-900 dark:text-white pt-2 border-t border-neutral-200 dark:border-neutral-800">
                <span>Total Amount:</span>
                <span class="text-[#9E7D36] dark:text-[#D4AF37]">{{ $order->formatted_total }}</span>
            </div>
            <div class="pt-2 text-[10px] text-neutral-500">
                <span>Method: {{ strtoupper($order->payment_method) }} ⬝ Status: {{ strtoupper($order->payment_status) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
