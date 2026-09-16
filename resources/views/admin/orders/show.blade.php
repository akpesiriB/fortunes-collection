@extends('layouts.admin')

@section('title', 'FULFILL ' . $order->order_number . ' | Fortunes Admin')
@section('page_title', 'Fulfillment: ' . $order->order_number)

@section('content')
<div class="max-w-5xl mx-auto space-y-8 font-mono text-xs">
    
    <div class="flex items-center justify-between border-b border-neutral-800 pb-4">
        <a href="{{ route('admin.orders.index') }}" class="text-neutral-400 hover:text-[#D4AF37]">← Back to Fulfillment Hub</a>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded text-[10px] font-bold uppercase border {{ $order->status_badge_class }}">
                Status: {{ $order->status }}
            </span>
            <button onclick="window.print()" class="px-3 py-1 border border-neutral-700 hover:border-neutral-500 rounded text-neutral-300">
                Print Invoice
            </button>
        </div>
    </div>

    <!-- Main Grid: Items (7 Cols) & Management Form (5 Cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Order Breakdown (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Items Card -->
            <div class="bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-4 shadow-xl">
                <h3 class="font-serif text-base font-bold uppercase text-white tracking-wider border-b border-neutral-800 pb-3">
                    ACQUIRED SILHOUETTES
                </h3>
                <div class="divide-y divide-neutral-800">
                    @foreach($order->items as $item)
                        <div class="py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                     class="w-14 h-18 object-cover rounded bg-neutral-900 border border-neutral-700">
                                <div>
                                    <span class="text-[10px] text-[#D4AF37] uppercase">{{ $item->product_sku }}</span>
                                    <h4 class="font-serif text-sm font-bold text-white uppercase">{{ $item->product_name }}</h4>
                                    <p class="text-neutral-400 text-[10px]">{{ $item->variant_details }}</p>
                                    <span class="text-neutral-500 text-[10px]">Qty: {{ $item->quantity }} × {{ $item->formatted_unit_price }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-white text-sm">{{ $item->formatted_subtotal }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-neutral-800 space-y-2 text-neutral-400">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span class="text-white">{{ $order->formatted_subtotal }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Dispatch Fee:</span>
                        <span class="text-[#D4AF37]">{{ $order->formatted_shipping_fee }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between text-emerald-400">
                            <span>Promo Discount:</span>
                            <span>{{ $order->formatted_discount }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base font-bold text-white pt-2 border-t border-neutral-800">
                        <span>Total Paid:</span>
                        <span class="text-[#D4AF37]">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Destination Card -->
            <div class="bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-3 shadow-xl">
                <h3 class="font-serif text-base font-bold uppercase text-white tracking-wider border-b border-neutral-800 pb-3">
                    CLIENT & DESTINATION
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-neutral-500 uppercase text-[10px] block">Client Name</span>
                        <p class="text-white font-bold">{{ $order->customer_name }}</p>
                        <p class="text-neutral-400">{{ $order->customer_email }}</p>
                        <p class="text-neutral-400">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <span class="text-neutral-500 uppercase text-[10px] block">Delivery Destination</span>
                        <p class="text-neutral-300">{{ $order->shippingAddress?->street_address }}</p>
                        @if($order->shippingAddress?->apartment)
                            <p class="text-neutral-400">{{ $order->shippingAddress->apartment }}</p>
                        @endif
                        <p class="text-neutral-400">{{ $order->shippingAddress?->city }}, {{ $order->shippingAddress?->state }}</p>
                        <p class="text-[#D4AF37] mt-1">{{ strtoupper($order->shipping_method) }}</p>
                    </div>
                </div>

                @if($order->customer_notes)
                    <div class="pt-3 border-t border-neutral-800">
                        <span class="text-neutral-500 uppercase text-[10px] block">Client Delivery Instructions:</span>
                        <p class="text-neutral-300 italic">{{ $order->customer_notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Payment Audit Trail -->
            <div class="bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-3 shadow-xl">
                <h3 class="font-serif text-base font-bold uppercase text-white tracking-wider border-b border-neutral-800 pb-3">
                    PAYMENT AUDIT LOG
                </h3>
                @forelse($order->payments as $payment)
                    <div class="p-3 bg-[#181818] border border-neutral-800 rounded-lg space-y-1 text-[11px]">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-white uppercase">{{ $payment->provider }} ({{ $payment->channel ?? 'card' }})</span>
                            <span class="px-2 py-0.5 rounded uppercase font-bold {{ $payment->status === 'successful' ? 'bg-emerald-950 text-emerald-400' : 'bg-neutral-800 text-neutral-400' }}">
                                {{ $payment->status }}
                            </span>
                        </div>
                        <p class="text-neutral-400">Ref: {{ $payment->reference }}</p>
                        <p class="text-neutral-400">Transaction ID: {{ $payment->transaction_id ?? 'N/A' }}</p>
                        <p class="text-neutral-500 text-[10px]">Verified At: {{ $payment->verified_at ? $payment->verified_at->format('M d, Y H:i:s') : 'Pending' }}</p>
                    </div>
                @empty
                    <p class="text-neutral-500">No payment records logged.</p>
                @endforelse
            </div>
        </div>

        <!-- Right: Status & Tracking Controls (5 Cols) -->
        <div class="lg:col-span-5 bg-[#141414] border border-[#D4AF37]/50 rounded-2xl p-6 space-y-6 shadow-2xl">
            <h3 class="font-serif text-lg font-bold uppercase text-white tracking-wider border-b border-neutral-800 pb-3">
                FULFILLMENT CONTROLS
            </h3>

            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Update Status</label>
                    <select name="status" class="w-full bg-[#1A1A1A] border border-neutral-700 focus:border-[#D4AF37] p-3 text-white rounded font-bold uppercase">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending Payment</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid (Ready for Atelier)</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>In Atelier Production</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dispatched with Courier</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered to Client</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled / Refunded</option>
                    </select>
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Courier Service</label>
                    <input type="text" name="courier_name" value="{{ old('courier_name', $order->courier_name ?? 'Maison Effurun Dedicated VIP Courier') }}"
                           class="w-full bg-[#1A1A1A] border border-neutral-700 focus:border-[#D4AF37] p-3 text-white rounded">
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Courier Tracking Code</label>
                    <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="FC-TRK-..."
                           class="w-full bg-[#1A1A1A] border border-neutral-700 focus:border-[#D4AF37] p-3 text-white rounded">
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Internal Atelier Notes</label>
                    <textarea name="internal_notes" rows="4" placeholder="Confidential staff notes, packaging specs, wax seal requests..."
                              class="w-full bg-[#1A1A1A] border border-neutral-700 focus:border-[#D4AF37] p-3 text-white rounded">{{ old('internal_notes', $order->internal_notes) }}</textarea>
                </div>

                <button type="submit" class="w-full py-4 btn-gold text-xs font-bold uppercase tracking-widest rounded shadow-xl">
                    Update Order Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
