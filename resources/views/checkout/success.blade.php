@extends('layouts.app')

@section('title', 'ORDER CONFIRMED | ' . $order->order_number)

@section('content')
@php
    $payment = $order->latestPayment;
    $method = $order->payment_method ?? ($payment?->provider ?? 'bank_transfer');
    $isPaid = $order->status === 'paid' || $order->payment_status === 'paid';
@endphp

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 space-y-10">
    
    <!-- Hero Header with Champagne Gold Aura -->
    <div class="text-center space-y-4 bg-white dark:bg-gradient-to-b dark:from-[#161616] dark:to-[#0f0f0f] border-2 border-[#9E7D36]/40 dark:border-[#C5A059]/50 rounded-2xl p-8 sm:p-12 shadow-xl relative overflow-hidden">
        <!-- Floating Gold Glow -->
        <div class="absolute -top-16 left-1/2 -translate-x-1/2 w-64 h-32 bg-[#C5A059]/15 blur-3xl pointer-events-none rounded-full"></div>

        <div class="w-16 h-16 bg-gradient-to-br from-[#F5E6C4] via-[#C5A059] to-[#8C6D28] text-black rounded-full mx-auto flex items-center justify-center font-serif text-2xl font-bold shadow-lg shadow-[#C5A059]/20">
            ✓
        </div>

        @if($method === 'bank_transfer')
            <span class="font-mono text-xs text-[#9E7D36] dark:text-[#C5A059] uppercase tracking-[0.3em] block font-bold">DIRECT ATELIER BANK TRANSFER INITIATED</span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">
                ORDER RESERVED
            </h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-300 font-sans max-w-lg mx-auto leading-relaxed">
                Thank you, {{ $order->customer_name }}. Your pieces have been reserved in the Fortunes Archive. Please complete transfer of <span class="text-[#9E7D36] dark:text-[#C5A059] font-bold font-mono">{{ $order->formatted_total }}</span> to begin finishing at our Effurun atelier.
            </p>
        @elseif($method === 'card')
            <span class="font-mono text-xs text-[#9E7D36] dark:text-[#C5A059] uppercase tracking-[0.3em] block font-bold">3D-SECURE CARD TRANSACTION APPROVED</span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">
                PAYMENT CONFIRMED
            </h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-300 font-sans max-w-lg mx-auto leading-relaxed">
                Thank you, {{ $order->customer_name }}. Your payment was authorized successfully. Your silhouettes are now entering hand-finishing at our Effurun atelier.
            </p>
        @else
            <span class="font-mono text-xs text-[#9E7D36] dark:text-[#C5A059] uppercase tracking-[0.3em] block font-bold">FORTUNES WEB3 VAULT TRANSACTION</span>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">
                TRANSACTION LOGGED
            </h1>
            <p class="text-sm text-neutral-600 dark:text-neutral-300 font-sans max-w-lg mx-auto leading-relaxed">
                Thank you, {{ $order->customer_name }}. Your crypto deposit has been recorded in our ledger. Once confirmed on the blockchain, your garments are dispatched from Effurun.
            </p>
        @endif

        <div class="inline-flex items-center gap-3 px-4 py-2 bg-[#FAF8F5] dark:bg-black/80 border border-[#9E7D36]/40 dark:border-[#C5A059]/40 rounded-full font-mono text-xs text-[#9E7D36] dark:text-[#C5A059]">
            <span>ORDER ARCHIVE NUMBER:</span>
            <span class="text-neutral-900 dark:text-white font-bold tracking-wider">{{ $order->order_number }}</span>
        </div>
    </div>

    <!-- Payment-Specific Action / Instruction Panel -->
    @if($method === 'bank_transfer')
        <div class="bg-white dark:bg-[#141414] border border-neutral-200 dark:border-[#C5A059]/40 rounded-xl p-6 sm:p-8 space-y-6 shadow-sm" x-data="{ copied: false }">
            <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#9E7D36] dark:bg-[#C5A059] animate-ping"></span>
                    <h3 class="font-serif text-base font-bold uppercase text-neutral-900 dark:text-white tracking-wider">OFFICIAL NIGERIAN SETTLEMENT ACCOUNT</h3>
                </div>
                <span class="font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-widest font-semibold">PTI ROAD, EFFURUN</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 font-mono text-xs">
                <div class="p-3.5 bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-200 dark:border-neutral-800 rounded-lg">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Beneficiary Bank</span>
                    <span class="font-serif text-sm font-bold text-neutral-900 dark:text-white">Guaranty Trust Bank (GTBank)</span>
                    <span class="block text-[10px] text-neutral-500 mt-0.5">Alt: Zenith Bank Plc</span>
                </div>
                <div class="p-3.5 bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-200 dark:border-neutral-800 rounded-lg">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Account Name</span>
                    <span class="font-serif text-sm font-bold text-neutral-900 dark:text-white">Fortunes Collection Atelier Ltd</span>
                    <span class="block text-[10px] text-neutral-500 mt-0.5">Corporate Account</span>
                </div>
                <div class="p-3.5 bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-200 dark:border-neutral-800 rounded-lg">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Amount Due</span>
                    <span class="font-serif text-sm font-bold text-[#9E7D36] dark:text-[#C5A059]">{{ $order->formatted_total }}</span>
                    <span class="block text-[10px] text-neutral-500 mt-0.5">Exact Total</span>
                </div>
            </div>

            <!-- NUBAN Copy Box -->
            <div class="p-4 bg-[#FAF8F5] dark:bg-[#0a0a0a] border border-[#9E7D36]/40 dark:border-[#C5A059]/60 rounded-xl flex items-center justify-between gap-4 shadow-sm">
                <div>
                    <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-widest">NUBAN Account Number</span>
                    <span class="font-mono text-2xl font-bold tracking-widest text-[#9E7D36] dark:text-[#C5A059]">0124892019</span>
                </div>
                <button type="button" @click="navigator.clipboard.writeText('0124892019'); copied = true; setTimeout(() => copied = false, 2500)"
                        class="px-5 py-2.5 rounded border border-[#9E7D36] dark:border-[#C5A059] hover:bg-[#9E7D36] hover:text-white dark:hover:bg-[#C5A059] dark:hover:text-black font-mono text-xs font-bold uppercase tracking-wider transition-all text-[#9E7D36] dark:text-[#C5A059]">
                    <span x-show="!copied">Copy Account No</span>
                    <span x-show="copied" class="text-emerald-600 dark:text-emerald-400">✓ Copied!</span>
                </button>
            </div>

            <!-- WhatsApp Concierge Fast Confirmation -->
            <div class="pt-2 flex flex-col sm:flex-row gap-3 items-center justify-between">
                <p class="font-mono text-xs text-neutral-600 dark:text-neutral-400">
                    Quote Order <strong class="text-neutral-900 dark:text-white">{{ $order->order_number }}</strong> in transfer narration for instant match.
                </p>
                <a href="https://wa.me/2348003678863?text=Hello%20Fortunes%20Collection%20Effurun,%20I%20have%20completed%20the%20transfer%20of%20{{ urlencode($order->formatted_total) }}%20for%20Order%20{{ $order->order_number }}"
                   target="_blank" rel="noopener noreferrer"
                   class="w-full sm:w-auto px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-mono text-xs font-bold uppercase tracking-wider rounded-lg shadow-lg flex items-center justify-center gap-2 transition-all">
                    <span>Notify Concierge via WhatsApp</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    @elseif($method === 'card')
        <div class="bg-white dark:bg-[#141414] border border-neutral-200 dark:border-[#C5A059]/40 rounded-xl p-6 space-y-4 font-mono text-xs shadow-sm">
            <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
                <h3 class="font-serif text-base font-bold uppercase text-neutral-900 dark:text-white tracking-wider">ELECTRONIC PAYMENT RECEIPT</h3>
                <span class="px-2.5 py-1 rounded bg-emerald-100 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 font-bold text-[10px] uppercase">
                    3D-SECURE SETTLED
                </span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#181818] rounded border border-neutral-200 dark:border-neutral-800">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Card Brand</span>
                    <span class="font-bold text-neutral-900 dark:text-white uppercase">{{ $payment?->raw_payload['brand'] ?? 'Debit Card' }}</span>
                </div>
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#181818] rounded border border-neutral-200 dark:border-neutral-800">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Card Digits</span>
                    <span class="font-bold text-neutral-900 dark:text-white tracking-wider">{{ $payment?->raw_payload['masked_card'] ?? '•••• 4242' }}</span>
                </div>
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#181818] rounded border border-neutral-200 dark:border-neutral-800">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Authorization</span>
                    <span class="font-bold text-[#9E7D36] dark:text-[#C5A059] tracking-wider">{{ $payment?->raw_payload['auth_code'] ?? 'AUTH_APPROVED' }}</span>
                </div>
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#181818] rounded border border-neutral-200 dark:border-neutral-800">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Settled Amount</span>
                    <span class="font-bold text-[#9E7D36] dark:text-[#C5A059]">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>
    @else
        <!-- Crypto Details Panel -->
        <div class="bg-white dark:bg-[#141414] border border-neutral-200 dark:border-[#C5A059]/40 rounded-xl p-6 space-y-4 font-mono text-xs shadow-sm" x-data="{ copied: false }">
            <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
                <h3 class="font-serif text-base font-bold uppercase text-neutral-900 dark:text-white tracking-wider">FORTUNES WEB3 VAULT DEPOSIT</h3>
                <span class="px-2.5 py-1 rounded bg-[#C5A059]/15 border border-[#C5A059]/40 text-[#9E7D36] dark:text-[#C5A059] font-bold text-[10px] uppercase">
                    AWAITING 1-CONF
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#181818] rounded border border-neutral-200 dark:border-neutral-800">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Selected Asset</span>
                    <span class="font-bold text-neutral-900 dark:text-white uppercase">{{ $payment?->raw_payload['asset_symbol'] ?? 'USDT' }}</span>
                </div>
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#181818] rounded border border-neutral-200 dark:border-neutral-800">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Approx Crypto Amount</span>
                    <span class="font-bold text-[#9E7D36] dark:text-[#C5A059]">{{ $payment?->raw_payload['approx_crypto_amount'] ?? 'USDT' }}</span>
                </div>
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#181818] rounded border border-neutral-200 dark:border-neutral-800">
                    <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Submitted TX Hash</span>
                    <span class="font-bold text-neutral-900 dark:text-white truncate block">{{ $payment?->transaction_id ?? 'PENDING' }}</span>
                </div>
            </div>

            <div class="space-y-1 pt-1">
                <span class="block text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Recipient Treasury Vault</span>
                <div class="p-3 bg-[#FAF8F5] dark:bg-[#0a0a0a] border border-[#9E7D36]/40 dark:border-[#C5A059]/50 rounded-xl flex items-center justify-between gap-3 shadow-sm">
                    <span class="text-neutral-900 dark:text-white text-xs break-all select-all font-semibold">
                        {{ $payment?->raw_payload['vault_address'] ?? 'TJFortunesEffurunAtelierVaultTRC99X' }}
                    </span>
                    <button type="button" @click="navigator.clipboard.writeText('{{ $payment?->raw_payload['vault_address'] ?? 'TJFortunesEffurunAtelierVaultTRC99X' }}'); copied = true; setTimeout(() => copied = false, 2500)"
                            class="shrink-0 px-3 py-1.5 rounded border border-[#9E7D36] dark:border-[#C5A059] hover:bg-[#9E7D36] hover:text-white dark:hover:bg-[#C5A059] dark:hover:text-black text-[11px] font-bold uppercase transition-all text-[#9E7D36] dark:text-[#C5A059]">
                        <span x-show="!copied">Copy Vault</span>
                        <span x-show="copied" class="text-emerald-600 dark:text-emerald-400">✓ Copied</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Fulfillment Timeline -->
    <div class="bg-white dark:bg-[#141414] border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 space-y-4 shadow-sm">
        <h3 class="font-serif text-base font-bold uppercase text-neutral-900 dark:text-white tracking-wider">DISPATCH TIMELINE</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center font-mono text-xs">
            <div class="p-3 bg-[#FAF8F5] dark:bg-[#1C1C1C] border {{ $isPaid ? 'border-emerald-500 dark:border-emerald-800/60 text-emerald-700 dark:text-emerald-400' : 'border-[#9E7D36]/60 dark:border-[#C5A059]/60 text-[#9E7D36] dark:text-[#C5A059]' }} rounded-lg">
                <span class="block font-bold">1. {{ $isPaid ? 'CONFIRMED' : 'RESERVED' }}</span>
                <span class="text-[10px] text-neutral-500 dark:text-neutral-400">{{ $isPaid ? 'Payment Verified' : 'Awaiting Transfer' }}</span>
            </div>
            <div class="p-3 bg-[#FAF8F5] dark:bg-[#1C1C1C] border border-[#9E7D36]/40 dark:border-[#C5A059]/40 text-[#9E7D36] dark:text-[#C5A059] rounded-lg">
                <span class="block font-bold">2. ATELIER PREP</span>
                <span class="text-[10px] text-neutral-500 dark:text-neutral-400">Hand-finished in Effurun</span>
            </div>
            <div class="p-3 bg-neutral-50 dark:bg-[#181818] border border-neutral-200 dark:border-neutral-800 rounded-lg text-neutral-400 dark:text-neutral-500">
                <span class="block font-bold">3. DISPATCHED</span>
                <span class="text-[10px] text-neutral-400 dark:text-neutral-600">VIP Courier Assigned</span>
            </div>
            <div class="p-3 bg-neutral-50 dark:bg-[#181818] border border-neutral-200 dark:border-neutral-800 rounded-lg text-neutral-400 dark:text-neutral-500">
                <span class="block font-bold">4. DELIVERED</span>
                <span class="text-[10px] text-neutral-400 dark:text-neutral-600">Signature Required</span>
            </div>
        </div>
    </div>

    <!-- Order Items & Receipt Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Items (7 Cols) -->
        <div class="md:col-span-7 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 space-y-4 shadow-sm">
            <h3 class="font-serif text-lg font-bold uppercase text-neutral-900 dark:text-white tracking-wider border-b border-neutral-200 dark:border-neutral-800 pb-3">
                RESERVED SILHOUETTES
            </h3>
            <div class="divide-y divide-neutral-200 dark:divide-neutral-800">
                @foreach($order->items as $item)
                    <div class="py-3 flex items-center justify-between gap-4 font-mono text-xs">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                 class="w-14 h-16 object-cover rounded bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                            <div>
                                <p class="font-serif text-sm font-semibold text-neutral-900 dark:text-white uppercase">{{ $item->product_name }}</p>
                                <p class="text-neutral-500 dark:text-neutral-400 text-[10px]">{{ $item->variant_details }}</p>
                                <span class="text-neutral-600 dark:text-neutral-300 text-[11px]">Qty: {{ $item->quantity }}</span>
                            </div>
                        </div>
                        <span class="text-neutral-900 dark:text-white font-bold">{{ $item->formatted_subtotal }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Delivery Details & Totals (5 Cols) -->
        <div class="md:col-span-5 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 space-y-6 font-mono text-xs shadow-sm">
            <div class="space-y-2 border-b border-neutral-200 dark:border-neutral-800 pb-4">
                <h4 class="font-serif text-base font-bold uppercase text-neutral-900 dark:text-white">DELIVERY DESTINATION</h4>
                <p class="text-neutral-800 dark:text-neutral-300 font-semibold">{{ $order->customer_name }}</p>
                <p class="text-neutral-600 dark:text-neutral-400">{{ $order->shippingAddress?->street_address }}</p>
                @if($order->shippingAddress?->apartment)
                    <p class="text-neutral-600 dark:text-neutral-400">{{ $order->shippingAddress->apartment }}</p>
                @endif
                <p class="text-neutral-600 dark:text-neutral-400">{{ $order->shippingAddress?->city }}, {{ $order->shippingAddress?->state }}</p>
                <p class="text-neutral-600 dark:text-neutral-400">{{ $order->customer_phone }}</p>
            </div>

            <div class="space-y-2 border-b border-neutral-200 dark:border-neutral-800 pb-4">
                <div class="flex justify-between text-neutral-600 dark:text-neutral-400">
                    <span>Subtotal:</span>
                    <span class="text-neutral-900 dark:text-white font-semibold">{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex justify-between text-neutral-600 dark:text-neutral-400">
                    <span>Dispatch Fee:</span>
                    <span class="text-[#9E7D36] dark:text-[#C5A059] font-semibold">{{ $order->formatted_shipping_fee }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-emerald-600 dark:text-emerald-400">
                        <span>Discount ({{ $order->coupon_code }}):</span>
                        <span>{{ $order->formatted_discount }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-base font-bold text-neutral-900 dark:text-white pt-2 border-t border-neutral-200 dark:border-neutral-800">
                    <span>Payable Total:</span>
                    <span class="text-[#9E7D36] dark:text-[#C5A059] font-serif text-xl">{{ $order->formatted_total }}</span>
                </div>
            </div>

            <div class="space-y-3">
                <a href="{{ route('shop.catalog') }}" class="block w-full text-center py-3.5 btn-gold text-xs font-bold tracking-widest uppercase rounded shadow-lg">
                    Return to Catalog
                </a>
                <button onclick="window.print()" class="block w-full text-center py-2.5 border border-neutral-300 dark:border-neutral-700 hover:border-[#9E7D36] dark:hover:border-[#C5A059] text-neutral-700 dark:text-neutral-300 hover:text-black dark:hover:text-white text-xs font-mono uppercase tracking-wider rounded transition-colors">
                    Print Order Invoice
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
