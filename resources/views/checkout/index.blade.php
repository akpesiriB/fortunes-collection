@extends('layouts.app')

@section('title', 'SECURE CHECKOUT | Fortunes Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8"
     x-data="checkoutManager()">
    
    <div class="border-b border-[#9E7D36]/30 dark:border-[#C5A059]/30 pb-4">
        <span class="font-mono text-xs tracking-[0.3em] text-[#9E7D36] dark:text-[#C5A059] uppercase">DIRECT BANK TRANSFER • CARDS • CRYPTOCURRENCY VAULT</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight mt-1">SECURE CHECKOUT</h1>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        @csrf

        <!-- Left: Customer & Address Details (7 Cols) -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- 1. Contact Information -->
            <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="flex justify-between items-center border-b border-neutral-200 dark:border-neutral-800 pb-3">
                    <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white tracking-wide">1. CLIENT INFORMATION</h2>
                    @guest('web')
                        <a href="{{ route('customer.login') }}" class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] hover:underline uppercase tracking-wider">
                            Sign in for saved addresses
                        </a>
                    @endguest
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Full Legal Name *</label>
                        <input type="text" name="name" required value="{{ old('name', $user?->name) }}"
                               placeholder="e.g. Korede Adeleke"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Email Address *</label>
                        <input type="email" name="email" required value="{{ old('email', $user?->email) }}"
                               placeholder="korede@example.com"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Nigerian Phone Number (For Courier) *</label>
                        <input type="tel" name="phone" required value="{{ old('phone', $savedAddress?->phone ?? $user?->phone) }}"
                               placeholder="+234 802 345 6789"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- 2. Nigerian Delivery Address -->
            <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-neutral-200 dark:border-neutral-800 pb-3">
                    <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white tracking-wide">2. DELIVERY DESTINATION</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Street Address *</label>
                        <input type="text" name="street_address" required value="{{ old('street_address', $savedAddress?->street_address) }}"
                               placeholder="e.g. Plot 14B, Admiralty Way"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Apartment, Suite, Unit</label>
                        <input type="text" name="apartment" value="{{ old('apartment', $savedAddress?->apartment) }}"
                               placeholder="e.g. Penthouse Suite"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">City / Area *</label>
                        <input type="text" name="city" required value="{{ old('city', $savedAddress?->city ?? 'Effurun') }}"
                               placeholder="Effurun / PTI Road"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none">
                    </div>

                    <div>
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">State / FCT *</label>
                        <select name="state" required
                                class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none font-mono">
                            <option value="Delta" {{ old('state', $savedAddress?->state ?? 'Delta') === 'Delta' ? 'selected' : '' }}>Delta (Effurun / Warri)</option>
                            <option value="Edo" {{ old('state', $savedAddress?->state) === 'Edo' ? 'selected' : '' }}>Edo (Benin)</option>
                            <option value="Rivers" {{ old('state', $savedAddress?->state) === 'Rivers' ? 'selected' : '' }}>Rivers (Port Harcourt)</option>
                            <option value="Abuja FCT" {{ old('state', $savedAddress?->state) === 'Abuja FCT' ? 'selected' : '' }}>Abuja FCT</option>
                            <option value="Ogun" {{ old('state', $savedAddress?->state) === 'Ogun' ? 'selected' : '' }}>Ogun</option>
                            <option value="Oyo" {{ old('state', $savedAddress?->state) === 'Oyo' ? 'selected' : '' }}>Oyo (Ibadan)</option>
                            <option value="Enugu" {{ old('state', $savedAddress?->state) === 'Enugu' ? 'selected' : '' }}>Enugu</option>
                            <option value="Kano" {{ old('state', $savedAddress?->state) === 'Kano' ? 'selected' : '' }}>Kano</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">LGA (Local Govt Area)</label>
                        <input type="text" name="lga" value="{{ old('lga', $savedAddress?->lga ?? 'Uvwie') }}"
                               placeholder="e.g. Uvwie, Warri South"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400 mb-1">Courier Delivery Instructions</label>
                        <textarea name="notes" rows="2" placeholder="e.g. Call gate security on arrival; fragile packaging requested."
                                  class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded-lg focus:outline-none"></textarea>
                    </div>
                </div>
            </div>

            <!-- 3. Nigerian Shipping Method -->
            <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-2xl p-6 sm:p-8 space-y-4 shadow-sm">
                <div class="border-b border-neutral-200 dark:border-neutral-800 pb-3">
                    <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white tracking-wide">3. DISPATCH METHOD</h2>
                </div>

                <div class="space-y-3">
                    @foreach($shippingMethods as $key => $method)
                        <label class="flex items-center justify-between p-4 rounded-xl cursor-pointer transition-all border"
                                :class="shippingMethod === '{{ $key }}' ? 'border-[#9E7D36] dark:border-[#D4AF37] bg-[#FAF6EE] dark:bg-[#1d1b14]' : 'border-neutral-200 dark:border-neutral-700 bg-[#FAF8F5] dark:bg-[#181818] hover:border-neutral-400 dark:hover:border-neutral-500'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_method" value="{{ $key }}"
                                       @change="updateShippingMethod('{{ $key }}')"
                                       :checked="shippingMethod === '{{ $key }}'"
                                       class="text-[#C5A059] focus:ring-[#C5A059]">
                                <div>
                                    <p class="font-mono text-xs font-bold text-neutral-900 dark:text-white uppercase">{{ $method['name'] }}</p>
                                    <span class="font-mono text-[10px] text-neutral-500 dark:text-neutral-400">{{ $method['time'] }}</span>
                                </div>
                            </div>
                            <span class="font-mono text-xs font-bold text-[#9E7D36] dark:text-[#D4AF37]">
                                @if($totals['subtotal'] >= 500000 && in_array($key, ['effurun_vip', 'delta_express', 'nationwide_express']))
                                    COMPLIMENTARY
                                @else
                                    ₦{{ number_format($method['fee'], 0) }}
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 4. Payment Infrastructure (Bank Transfer, Cards, Cryptocurrency) -->
            <div class="bg-white dark:bg-[#121212] border border-[#C5A059]/30 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
                <div class="border-b border-[#C5A059]/20 pb-3 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white tracking-wide">4. SELECT PAYMENT ARCHITECTURE</h2>
                        <p class="font-mono text-[11px] text-neutral-500 dark:text-neutral-400 mt-0.5">Direct Nigerian Bank Transfer, Global Cards, or Fortunes Web3 Vault</p>
                    </div>
                    <span class="px-2.5 py-1 rounded bg-[#C5A059]/15 border border-[#C5A059]/30 text-[#9E7D36] dark:text-[#C5A059] font-mono text-[10px] uppercase font-bold tracking-wider">
                        SECURE NIGERIAN ESCROW
                    </span>
                </div>

                <!-- 3 Payment Method Selection Tabs -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Option 1: Bank Transfer -->
                    <label class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between"
                           :class="paymentMethod === 'bank_transfer' ? 'border-[#9E7D36] dark:border-[#C5A059] bg-[#FAF4E8] dark:bg-[#1d1b14] ring-1 ring-[#9E7D36] dark:ring-[#C5A059]' : 'border-neutral-200 dark:border-neutral-800 bg-[#FAF8F5] dark:bg-[#161616] hover:border-neutral-400 dark:hover:border-neutral-700'">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="text-[#9E7D36] dark:text-[#C5A059] focus:ring-[#C5A059]">
                                <span class="font-mono text-xs font-bold uppercase text-neutral-900 dark:text-white">BANK TRANSFER</span>
                            </div>
                            <svg class="w-4 h-4 text-[#9E7D36] dark:text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                        </div>
                        <p class="font-mono text-[10px] text-neutral-600 dark:text-neutral-400 mt-2">Instant GTBank / Zenith corporate NUBAN deposit with VIP concierge confirmation</p>
                    </label>

                    <!-- Option 2: Cards -->
                    <label class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between"
                           :class="paymentMethod === 'card' ? 'border-[#9E7D36] dark:border-[#C5A059] bg-[#FAF4E8] dark:bg-[#1d1b14] ring-1 ring-[#9E7D36] dark:ring-[#C5A059]' : 'border-neutral-200 dark:border-neutral-800 bg-[#FAF8F5] dark:bg-[#161616] hover:border-neutral-400 dark:hover:border-neutral-700'">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="text-[#9E7D36] dark:text-[#C5A059] focus:ring-[#C5A059]">
                                <span class="font-mono text-xs font-bold uppercase text-neutral-900 dark:text-white">DEBIT / CREDIT CARD</span>
                            </div>
                            <svg class="w-4 h-4 text-[#9E7D36] dark:text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <p class="font-mono text-[10px] text-neutral-600 dark:text-neutral-400 mt-2">Visa, Mastercard, Verve with instant 3D-Secure biometric authorization</p>
                    </label>

                    <!-- Option 3: Cryptocurrency -->
                    <label class="p-4 rounded-xl border cursor-pointer transition-all flex flex-col justify-between"
                           :class="paymentMethod === 'crypto' ? 'border-[#9E7D36] dark:border-[#C5A059] bg-[#FAF4E8] dark:bg-[#1d1b14] ring-1 ring-[#9E7D36] dark:ring-[#C5A059]' : 'border-neutral-200 dark:border-neutral-800 bg-[#FAF8F5] dark:bg-[#161616] hover:border-neutral-400 dark:hover:border-neutral-700'">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="payment_method" value="crypto" x-model="paymentMethod" class="text-[#9E7D36] dark:text-[#C5A059] focus:ring-[#C5A059]">
                                <span class="font-mono text-xs font-bold uppercase text-neutral-900 dark:text-white">CRYPTO VAULT</span>
                            </div>
                            <svg class="w-4 h-4 text-[#9E7D36] dark:text-[#C5A059]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="font-mono text-[10px] text-neutral-600 dark:text-neutral-400 mt-2">USDT TRC20/ERC20, Bitcoin (BTC), Ethereum (ETH) direct to Fortunes Vault</p>
                    </label>
                </div>

                <!-- Tab Details Panels -->

                <!-- Panel 1: Bank Transfer Details -->
                <div x-show="paymentMethod === 'bank_transfer'" x-cloak class="space-y-4 pt-2">
                    <div class="bg-gradient-to-br from-[#FAF8F5] to-[#F5F1E8] dark:from-[#181818] dark:to-[#121212] border border-[#C5A059]/30 dark:border-[#C5A059]/40 rounded-xl p-5 space-y-4 relative overflow-hidden">
                        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                <span class="font-mono text-xs font-bold text-neutral-900 dark:text-white uppercase">OFFICIAL ATELIER CORPORATE ACCOUNT</span>
                            </div>
                            <span class="font-mono text-[10px] text-[#9E7D36] dark:text-[#C5A059] uppercase tracking-wider font-semibold">EFFURUN, DELTA STATE</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-white dark:bg-[#141414] border border-neutral-200 dark:border-neutral-800 p-3.5 rounded-lg shadow-sm">
                                <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Primary Deposit Bank</span>
                                <span class="font-serif text-sm font-bold text-neutral-900 dark:text-white">Guaranty Trust Bank (GTBank)</span>
                                <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-500 mt-0.5">Alt: Zenith Bank Plc</span>
                            </div>
                            <div class="bg-white dark:bg-[#141414] border border-neutral-200 dark:border-neutral-800 p-3.5 rounded-lg shadow-sm">
                                <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase">Account Beneficiary</span>
                                <span class="font-serif text-sm font-bold text-neutral-900 dark:text-white">Fortunes Collection Atelier Ltd</span>
                                <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-500 mt-0.5">Effurun Commercial Hub Branch</span>
                            </div>
                        </div>

                        <!-- Account Number Box with 1-Click Copy -->
                        <div class="p-4 bg-white dark:bg-[#0a0a0a] border border-[#C5A059]/40 dark:border-[#C5A059]/50 rounded-xl flex items-center justify-between gap-4 shadow-sm">
                            <div>
                                <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-widest">NUBAN Account Number</span>
                                <span class="font-mono text-xl sm:text-2xl font-bold tracking-widest text-[#9E7D36] dark:text-[#C5A059]">0124892019</span>
                            </div>
                            <button type="button" @click="navigator.clipboard.writeText('0124892019'); copiedBank = true; setTimeout(() => copiedBank = false, 2500)"
                                    class="px-4 py-2 rounded border border-[#9E7D36]/60 dark:border-[#C5A059]/60 hover:bg-[#9E7D36] hover:text-white dark:hover:bg-[#C5A059] dark:hover:text-black font-mono text-xs font-bold uppercase tracking-wider transition-all text-[#9E7D36] dark:text-[#C5A059]">
                                <span x-show="!copiedBank">Copy NUBAN</span>
                                <span x-show="copiedBank" class="text-emerald-600 dark:text-emerald-400">✓ Copied!</span>
                            </button>
                        </div>

                        <!-- Transfer Reference Form Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                            <div>
                                <label class="block font-mono text-[10px] uppercase text-neutral-600 dark:text-neutral-400 mb-1">Your Sender Account Name</label>
                                <input type="text" name="bank_sender_name" placeholder="e.g. Korede Adeleke"
                                       class="w-full bg-white dark:bg-[#161616] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-2.5 text-xs text-neutral-900 dark:text-white rounded focus:outline-none font-mono">
                            </div>
                            <div>
                                <label class="block font-mono text-[10px] uppercase text-neutral-600 dark:text-neutral-400 mb-1">Payment Reference / Session ID (Optional)</label>
                                <input type="text" name="bank_transfer_ref" placeholder="e.g. GTB/TRF/98372"
                                       class="w-full bg-white dark:bg-[#161616] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-2.5 text-xs text-neutral-900 dark:text-white rounded focus:outline-none font-mono">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel 2: Direct Card Details -->
                <div x-show="paymentMethod === 'card'" x-cloak class="space-y-4 pt-2">
                    <div class="bg-gradient-to-br from-[#FAF8F5] to-[#F5F1E8] dark:from-[#181818] dark:to-[#121212] border border-[#C5A059]/30 dark:border-[#C5A059]/40 rounded-xl p-5 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-bold text-neutral-900 dark:text-white uppercase">DIRECT CARD AUTHORIZATION</span>
                                <span class="px-2 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 font-mono text-[9px] uppercase font-bold">
                                    3D-SECURE VERIFIED
                                </span>
                            </div>
                            <!-- Accepted Cards Badges -->
                            <div class="flex items-center gap-2 text-[10px] font-mono font-bold text-neutral-500 dark:text-neutral-400">
                                <span class="px-1.5 py-0.5 bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-800 rounded text-blue-600 dark:text-blue-400">VISA</span>
                                <span class="px-1.5 py-0.5 bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-800 rounded text-orange-600 dark:text-orange-400">MC</span>
                                <span class="px-1.5 py-0.5 bg-white dark:bg-neutral-900 border border-neutral-300 dark:border-neutral-800 rounded text-emerald-600 dark:text-emerald-400">VERVE</span>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="block font-mono text-[10px] uppercase text-neutral-600 dark:text-neutral-400 mb-1">Cardholder Legal Name *</label>
                                <input type="text" name="card_name" x-model="cardName" placeholder="Korede Adeleke"
                                       class="w-full bg-white dark:bg-[#161616] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded focus:outline-none font-mono">
                            </div>

                            <div>
                                <label class="block font-mono text-[10px] uppercase text-neutral-600 dark:text-neutral-400 mb-1">Card Number (16-19 Digits) *</label>
                                <div class="relative">
                                    <input type="text" name="card_number" x-model="cardNumber" @input="formatCardNumber($event)"
                                           placeholder="4123 4567 8901 2345" maxlength="19"
                                           class="w-full bg-white dark:bg-[#161616] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded focus:outline-none font-mono tracking-widest pl-11">
                                    <div class="absolute left-3.5 top-3 text-[#9E7D36] dark:text-[#C5A059]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-mono text-[10px] uppercase text-neutral-600 dark:text-neutral-400 mb-1">Expiry Date *</label>
                                    <input type="text" name="card_expiry" x-model="cardExpiry" @input="formatExpiry($event)"
                                           placeholder="MM / YY" maxlength="7"
                                           class="w-full bg-white dark:bg-[#161616] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded focus:outline-none font-mono tracking-wider">
                                </div>
                                <div>
                                    <label class="block font-mono text-[10px] uppercase text-neutral-600 dark:text-neutral-400 mb-1">Security CVV *</label>
                                    <input type="password" name="card_cvv" x-model="cardCvv" placeholder="•••" maxlength="4"
                                           class="w-full bg-white dark:bg-[#161616] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded focus:outline-none font-mono tracking-widest">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-[10px] font-mono text-neutral-600 dark:text-neutral-500 pt-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>End-to-end encrypted under 256-bit TLS protocol. Card data is never stored unencrypted.</span>
                        </div>
                    </div>
                </div>

                <!-- Panel 3: Cryptocurrency Vault Details -->
                <div x-show="paymentMethod === 'crypto'" x-cloak class="space-y-4 pt-2">
                    <div class="bg-gradient-to-br from-[#FAF8F5] to-[#F5F1E8] dark:from-[#181818] dark:to-[#121212] border border-[#C5A059]/30 dark:border-[#C5A059]/40 rounded-xl p-5 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-bold text-neutral-900 dark:text-white uppercase">FORTUNES WEB3 VAULT</span>
                                <span class="px-2 py-0.5 rounded bg-[#C5A059]/15 border border-[#C5A059]/40 text-[#9E7D36] dark:text-[#C5A059] font-mono text-[9px] uppercase font-bold">
                                    ON-CHAIN DEPOSIT
                                </span>
                            </div>
                            <span class="font-mono text-[10px] text-neutral-500 dark:text-neutral-400">INSTANT DISPATCH ON 1-CONF</span>
                        </div>

                        <!-- Asset Selector Buttons -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                            <button type="button" @click="cryptoAsset = 'usdt_trc20'"
                                    :class="cryptoAsset === 'usdt_trc20' ? 'border-[#9E7D36] dark:border-[#C5A059] bg-[#FAF4E8] dark:bg-[#C5A059]/20 text-[#9E7D36] dark:text-[#C5A059]' : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-[#161616] text-neutral-600 dark:text-neutral-400'"
                                    class="py-2.5 px-3 rounded-lg border font-mono text-xs font-bold uppercase tracking-wider transition-all flex flex-col items-center">
                                <span>USDT</span>
                                <span class="text-[9px] opacity-70">TRC20 (Fastest)</span>
                            </button>
                            <button type="button" @click="cryptoAsset = 'usdt_erc20'"
                                    :class="cryptoAsset === 'usdt_erc20' ? 'border-[#9E7D36] dark:border-[#C5A059] bg-[#FAF4E8] dark:bg-[#C5A059]/20 text-[#9E7D36] dark:text-[#C5A059]' : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-[#161616] text-neutral-600 dark:text-neutral-400'"
                                    class="py-2.5 px-3 rounded-lg border font-mono text-xs font-bold uppercase tracking-wider transition-all flex flex-col items-center">
                                <span>USDT</span>
                                <span class="text-[9px] opacity-70">ERC20</span>
                            </button>
                            <button type="button" @click="cryptoAsset = 'btc'"
                                    :class="cryptoAsset === 'btc' ? 'border-[#9E7D36] dark:border-[#C5A059] bg-[#FAF4E8] dark:bg-[#C5A059]/20 text-[#9E7D36] dark:text-[#C5A059]' : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-[#161616] text-neutral-600 dark:text-neutral-400'"
                                    class="py-2.5 px-3 rounded-lg border font-mono text-xs font-bold uppercase tracking-wider transition-all flex flex-col items-center">
                                <span>BITCOIN</span>
                                <span class="text-[9px] opacity-70">BTC Native</span>
                            </button>
                            <button type="button" @click="cryptoAsset = 'eth'"
                                    :class="cryptoAsset === 'eth' ? 'border-[#9E7D36] dark:border-[#C5A059] bg-[#FAF4E8] dark:bg-[#C5A059]/20 text-[#9E7D36] dark:text-[#C5A059]' : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-[#161616] text-neutral-600 dark:text-neutral-400'"
                                    class="py-2.5 px-3 rounded-lg border font-mono text-xs font-bold uppercase tracking-wider transition-all flex flex-col items-center">
                                <span>ETHEREUM</span>
                                <span class="text-[9px] opacity-70">ETH Mainnet</span>
                            </button>
                        </div>

                        <!-- Hidden input for form submission -->
                        <input type="hidden" name="crypto_asset" :value="cryptoAsset">

                        <!-- Real-time Crypto Conversion Estimate -->
                        <div class="p-3.5 bg-white dark:bg-[#141414] border border-neutral-200 dark:border-neutral-800 rounded-lg flex items-center justify-between">
                            <span class="font-mono text-xs text-neutral-600 dark:text-neutral-400 uppercase">Estimated Payable:</span>
                            <span class="font-mono text-sm font-bold text-[#9E7D36] dark:text-[#C5A059]" x-text="getCryptoAmountEstimate()">
                                ~ {{ number_format($totals['total_amount'] / 1550, 2) }} USDT
                            </span>
                        </div>

                        <!-- Vault Address Box with 1-Click Copy -->
                        <div class="space-y-1.5">
                            <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Fortunes Collection Treasury Address</span>
                            <div class="p-3 bg-white dark:bg-[#0a0a0a] border border-[#C5A059]/40 dark:border-[#C5A059]/50 rounded-xl flex items-center justify-between gap-3 shadow-sm">
                                <span class="font-mono text-xs text-neutral-900 dark:text-white break-all select-all font-semibold" x-text="getCryptoVaultAddress()">
                                    TJFortunesEffurunAtelierVaultTRC99X
                                </span>
                                <button type="button" @click="navigator.clipboard.writeText(getCryptoVaultAddress()); copiedVault = true; setTimeout(() => copiedVault = false, 2500)"
                                        class="shrink-0 px-3 py-1.5 rounded border border-[#9E7D36]/60 dark:border-[#C5A059]/60 hover:bg-[#9E7D36] hover:text-white dark:hover:bg-[#C5A059] dark:hover:text-black font-mono text-[11px] font-bold uppercase tracking-wider transition-all text-[#9E7D36] dark:text-[#C5A059]">
                                    <span x-show="!copiedVault">Copy</span>
                                    <span x-show="copiedVault" class="text-emerald-600 dark:text-emerald-400">✓ Copied</span>
                                </button>
                            </div>
                        </div>

                        <!-- TX Hash Input -->
                        <div>
                            <label class="block font-mono text-[10px] uppercase text-neutral-600 dark:text-neutral-400 mb-1">Transaction Hash / TXID (Or Sender Wallet Address)</label>
                            <input type="text" name="crypto_tx_hash" placeholder="e.g. 0x4f8a... or T98x..."
                                   class="w-full bg-white dark:bg-[#161616] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] p-3 text-xs text-neutral-900 dark:text-white rounded focus:outline-none font-mono">
                            <span class="block font-mono text-[10px] text-neutral-500 dark:text-neutral-500 mt-1">If paying after order creation, you can quote this order number to our WhatsApp concierge.</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Right: Order Review & Recalculated Summary (5 Cols) -->
        <div class="lg:col-span-5 bg-white dark:bg-[#141414] border border-neutral-200 dark:border-[#C5A059]/50 rounded-2xl p-6 sm:p-8 space-y-6 shadow-xl sticky top-28">
            <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white tracking-wider border-b border-neutral-200 dark:border-neutral-800 pb-3">
                ORDER CONFIRMATION
            </h2>

            <!-- Line Items Mini List -->
            <div class="max-h-64 overflow-y-auto divide-y divide-neutral-200 dark:divide-neutral-800 pr-2 space-y-3">
                @foreach($cart['items'] as $item)
                    <div class="flex items-center justify-between pt-3 text-xs font-mono">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-14 object-cover rounded bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800">
                            <div>
                                <p class="font-serif text-sm font-semibold text-neutral-900 dark:text-white uppercase">{{ $item['name'] }}</p>
                                <span class="text-neutral-500 dark:text-neutral-400 text-[10px]">{{ $item['variant_details'] ?? 'Standard' }} (x{{ $item['quantity'] }})</span>
                            </div>
                        </div>
                        <span class="text-neutral-900 dark:text-white font-bold">{{ $item['formatted_subtotal'] }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Promo Code Box -->
            <div class="pt-4 border-t border-neutral-200 dark:border-neutral-800">
                <div class="flex gap-2">
                    <input type="text" x-model="couponInput" placeholder="Promo code (e.g. FORTUNES10)"
                           class="flex-1 bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 px-3 py-2 text-xs font-mono text-neutral-900 dark:text-white uppercase focus:outline-none focus:border-[#C5A059] rounded">
                    <button type="button" @click="applyCouponCode()"
                            class="px-4 py-2 bg-neutral-200 dark:bg-neutral-800 hover:bg-[#C5A059] text-neutral-800 dark:text-neutral-200 hover:text-black text-xs font-mono font-bold uppercase rounded transition-colors">
                        Apply
                    </button>
                </div>
                <p x-show="couponMessage" class="text-[11px] font-mono mt-1"
                   :class="couponValid ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400'"
                   x-text="couponMessage"></p>
            </div>

            <!-- Server Calculated Totals -->
            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-4 space-y-2.5 font-mono text-xs">
                <div class="flex justify-between text-neutral-600 dark:text-neutral-300">
                    <span class="uppercase">Silhouettes Subtotal:</span>
                    <span class="text-neutral-900 dark:text-white font-bold" x-text="totals.formatted_subtotal">{{ $totals['formatted_subtotal'] }}</span>
                </div>
                <div class="flex justify-between text-neutral-600 dark:text-neutral-300">
                    <span class="uppercase">Nigerian Dispatch:</span>
                    <span class="text-[#9E7D36] dark:text-[#C5A059] font-bold" x-text="totals.formatted_shipping_fee">{{ $totals['formatted_shipping_fee'] }}</span>
                </div>
                <div x-show="totals.discount_amount > 0" class="flex justify-between text-emerald-600 dark:text-emerald-400">
                    <span class="uppercase">Promotional Discount:</span>
                    <span class="font-bold" x-text="totals.formatted_discount">{{ $totals['formatted_discount'] }}</span>
                </div>
            </div>

            <!-- Grand Total -->
            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-4 flex justify-between items-center font-mono">
                <span class="text-xs uppercase text-neutral-500 dark:text-neutral-400 tracking-wider">Payable Total:</span>
                <span class="font-serif text-3xl font-bold text-[#9E7D36] dark:text-[#C5A059]" x-text="totals.formatted_total">{{ $totals['formatted_total'] }}</span>
            </div>

            <input type="hidden" name="coupon_code" :value="totals.coupon_code">

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full py-4 btn-gold text-xs font-bold tracking-widest uppercase rounded-lg shadow-xl flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span x-text="getSubmitButtonText()">PLACE ORDER</span>
            </button>

            <div class="text-[10px] font-mono text-neutral-500 text-center leading-relaxed">
                Fortunes Atelier Effurun Concierge Protocol. Authenticated checkout with instant order routing. Dispatched directly from Effurun, Delta State.
            </div>
        </div>
    </form>
</div>

<script>
    function checkoutManager() {
        return {
            shippingMethod: '{{ $totals['shipping_method'] }}',
            paymentMethod: 'bank_transfer',
            cryptoAsset: 'usdt_trc20',
            cardName: '{{ $user?->name ?? '' }}',
            cardNumber: '',
            cardExpiry: '',
            cardCvv: '',
            copiedBank: false,
            copiedVault: false,
            couponInput: '{{ $totals['coupon_code'] }}',
            couponMessage: '{{ $totals['coupon_result']['message'] ?? '' }}',
            couponValid: {{ !empty($totals['coupon_code']) ? 'true' : 'false' }},
            totals: @json($totals),

            getSubmitButtonText() {
                if (this.paymentMethod === 'bank_transfer') {
                    return 'PLACE ORDER VIA BANK TRANSFER (' + this.totals.formatted_total + ')';
                }
                if (this.paymentMethod === 'card') {
                    return 'AUTHORIZE CARD PAYMENT (' + this.totals.formatted_total + ')';
                }
                return 'CONFIRM CRYPTOCURRENCY PAYMENT (' + this.totals.formatted_total + ')';
            },

            getCryptoVaultAddress() {
                switch (this.cryptoAsset) {
                    case 'usdt_trc20': return 'TJFortunesEffurunAtelierVaultTRC99X';
                    case 'usdt_erc20': return '0x789A4B3e2F18De79B0D18F87EF384F958aA19842';
                    case 'btc': return 'bc1qeffurunarchivefortunescollection88';
                    case 'eth': return '0x789A4B3e2F18De79B0D18F87EF384F958aA19842';
                    default: return 'TJFortunesEffurunAtelierVaultTRC99X';
                }
            },

            getCryptoAmountEstimate() {
                const total = this.totals.total_amount;
                if (this.cryptoAsset === 'btc') {
                    return '~ ' + (total / 98000000).toFixed(6) + ' BTC';
                }
                if (this.cryptoAsset === 'eth') {
                    return '~ ' + (total / 4800000).toFixed(5) + ' ETH';
                }
                return '~ ' + (total / 1550).toFixed(2) + ' USDT';
            },

            formatCardNumber(e) {
                let value = e.target.value.replace(/\D/g, '');
                let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
                this.cardNumber = formatted;
            },

            formatExpiry(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    this.cardExpiry = value.slice(0, 2) + ' / ' + value.slice(2, 4);
                } else {
                    this.cardExpiry = value;
                }
            },

            updateShippingMethod(method) {
                this.shippingMethod = method;
                this.recalculate();
            },

            applyCouponCode() {
                this.recalculate();
            },

            recalculate() {
                fetch('{{ route('checkout.calculate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        shipping_method: this.shippingMethod,
                        coupon_code: this.couponInput
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        this.totals = data.totals;
                        if (data.totals.coupon_result) {
                            this.couponValid = data.totals.coupon_result.valid;
                            this.couponMessage = data.totals.coupon_result.message;
                        }
                    }
                });
            }
        };
    }
</script>
@endsection
