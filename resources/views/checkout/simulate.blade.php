@extends('layouts.app')

@section('title', 'PAYSTACK SECURE SIMULATOR | Fortunes Collection')

@section('content')
<div class="max-w-xl mx-auto px-4 py-16 space-y-8">
    <div class="bg-[#121212] border-2 border-[#D4AF37] rounded-2xl p-8 shadow-2xl space-y-6 relative overflow-hidden">
        
        <!-- Paystack Header -->
        <div class="flex items-center justify-between border-b border-neutral-800 pb-4">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="font-mono text-xs text-white font-bold uppercase tracking-wider">Paystack Sandbox Gateway</span>
            </div>
            <span class="px-2.5 py-1 rounded bg-[#1F1F1F] text-[#D4AF37] font-mono text-[10px] uppercase font-bold tracking-widest border border-[#D4AF37]/30">
                3D Secure
            </span>
        </div>

        <!-- Transaction Details -->
        <div class="text-center space-y-2 py-4">
            <span class="font-mono text-xs uppercase text-neutral-400 tracking-widest">Amount to Pay</span>
            <h2 class="font-serif text-4xl font-bold text-white tracking-tight">
                {{ $order->formatted_total }}
            </h2>
            <p class="font-mono text-xs text-[#D4AF37]">Reference: {{ $reference }}</p>
        </div>

        <!-- Order Summary Mini -->
        <div class="p-4 bg-[#181818] border border-neutral-800 rounded-xl space-y-2 font-mono text-xs">
            <div class="flex justify-between text-neutral-400">
                <span>Order Number:</span>
                <span class="text-white">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between text-neutral-400">
                <span>Client Name:</span>
                <span class="text-white">{{ $order->customer_name }}</span>
            </div>
            <div class="flex justify-between text-neutral-400">
                <span>Client Email:</span>
                <span class="text-white">{{ $order->customer_email }}</span>
            </div>
            <div class="flex justify-between text-neutral-400">
                <span>Payment Channel:</span>
                <span class="text-emerald-400">Card / Bank Transfer / USSD</span>
            </div>
        </div>

        <!-- Simulator Actions -->
        <div class="space-y-3 pt-2">
            <a href="{{ route('checkout.verify', ['reference' => $reference]) }}"
               class="block w-full text-center py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-mono font-bold text-xs uppercase tracking-widest rounded-lg shadow-lg transition-all">
                ✓ SIMULATE SUCCESSFUL PAYMENT
            </a>

            <a href="{{ route('checkout.index') }}"
               class="block w-full text-center py-3 border border-neutral-700 hover:border-neutral-500 text-neutral-400 hover:text-white font-mono text-xs uppercase tracking-wider rounded-lg transition-colors">
                Cancel / Return to Checkout
            </a>
        </div>

        <div class="text-center">
            <p class="font-mono text-[10px] text-neutral-500">
                This is a secure local simulation of the Paystack verification webhook and callback pipeline. In production, this redirects directly to Paystack's banking interface.
            </p>
        </div>
    </div>
</div>
@endsection
