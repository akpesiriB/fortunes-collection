@extends('layouts.app')

@section('title', 'SHOPPING BAG | Fortunes Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <div class="border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-4">
        <span class="font-mono text-xs tracking-[0.3em] text-[#9E7D36] dark:text-[#D4AF37] uppercase">CHECKOUT PREPARATION</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight mt-1">YOUR ARCHIVE BAG</h1>
    </div>

    @if(empty($cart['items']))
        <div class="text-center py-20 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-2xl space-y-4 shadow-sm">
            <div class="w-16 h-16 border border-[#C5A059]/40 mx-auto flex items-center justify-center text-[#9E7D36] dark:text-[#D4AF37] rounded-full">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="font-serif text-2xl text-neutral-900 dark:text-white">Your archive bag is empty</p>
            <p class="text-xs text-neutral-600 dark:text-neutral-400 font-mono tracking-widest">No silhouettes have been selected for dispatch yet.</p>
            <a href="{{ route('shop.catalog') }}" class="inline-block mt-4 px-8 py-3.5 btn-gold text-xs font-bold tracking-widest">
                EXPLORE THE ARCHIVE
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left: Bag Items List (8 Cols) -->
            <div class="lg:col-span-8 space-y-4">
                
                <!-- Free Shipping Indicator -->
                <div class="p-4 bg-white dark:bg-[#141414] border border-[#C5A059]/30 dark:border-[#D4AF37]/30 rounded-xl space-y-2 shadow-sm">
                    <div class="flex justify-between text-xs font-mono tracking-wider uppercase">
                        <span class="text-neutral-900 dark:text-white">Effurun & Delta VIP White-Glove Dispatch</span>
                        <span class="text-[#9E7D36] dark:text-[#D4AF37]">
                            {{ $cart['free_shipping_qualified'] ? 'COMPLIMENTARY' : 'ADD ' . $cart['formatted_amount_needed'] . ' FOR COMPLIMENTARY DISPATCH' }}
                        </span>
                    </div>
                    <div class="w-full bg-neutral-200 dark:bg-neutral-800 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-[#9F7B18] via-[#D4AF37] to-[#F5D061] h-full transition-all duration-500"
                             style="width: {{ $cart['free_shipping_progress'] }}%"></div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden divide-y divide-neutral-200 dark:divide-neutral-800 shadow-sm">
                    @foreach($cart['items'] as $item)
                        <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                            
                            <div class="flex items-center gap-4">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                     class="w-20 h-24 object-contain rounded-lg bg-[#FBF9F5] dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 p-1">
                                <div>
                                    <span class="font-mono text-[10px] text-[#9E7D36] dark:text-[#D4AF37] uppercase tracking-widest block">{{ $item['sku'] }}</span>
                                    <h3 class="font-serif text-base font-bold text-neutral-900 dark:text-white uppercase">{{ $item['name'] }}</h3>
                                    <p class="font-mono text-xs text-neutral-600 dark:text-neutral-400 mt-0.5">{{ $item['variant_details'] ?? 'Standard Edition' }}</p>
                                    <span class="font-mono text-xs text-neutral-900 dark:text-white font-semibold mt-1 block">{{ $item['formatted_price'] }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                <!-- Quantity -->
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-neutral-300 dark:border-neutral-700 rounded-lg overflow-hidden bg-white dark:bg-[#181818]">
                                    @csrf
                                    <input type="hidden" name="item_key" value="{{ $item['key'] }}">
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-3 py-1.5 text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white bg-neutral-100 dark:bg-neutral-800 text-xs font-mono">-</button>
                                    <span class="px-4 py-1.5 text-xs font-mono text-neutral-900 dark:text-white">{{ $item['quantity'] }}</span>
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 py-1.5 text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white bg-neutral-100 dark:bg-neutral-800 text-xs font-mono">+</button>
                                </form>

                                <span class="font-mono text-base font-bold text-[#9E7D36] dark:text-[#D4AF37] min-w-[100px] text-right">
                                    {{ $item['formatted_subtotal'] }}
                                </span>

                                <!-- Remove -->
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="item_key" value="{{ $item['key'] }}">
                                    <button type="submit" class="text-neutral-400 hover:text-red-500 p-2" title="Remove silhouette">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Order Summary Box (4 Cols) -->
            <div class="lg:col-span-4 bg-white dark:bg-[#141414] border border-[#C5A059]/40 dark:border-[#D4AF37]/40 rounded-2xl p-6 space-y-6 shadow-xl">
                <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white tracking-wider border-b border-neutral-200 dark:border-neutral-800 pb-3">
                    ARCHIVE SUMMARY
                </h2>

                <div class="space-y-3 font-mono text-xs">
                    <div class="flex justify-between text-neutral-700 dark:text-neutral-300">
                        <span class="uppercase">Silhouettes Subtotal</span>
                        <span class="text-neutral-900 dark:text-white font-bold">{{ $cart['formatted_subtotal'] }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-700 dark:text-neutral-300">
                        <span class="uppercase">Estimated Delivery</span>
                        <span class="text-[#9E7D36] dark:text-[#D4AF37]">{{ $cart['free_shipping_qualified'] ? 'COMPLIMENTARY' : 'Calculated at Checkout' }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-neutral-200 dark:border-neutral-800 flex justify-between items-center font-mono">
                    <span class="text-xs uppercase text-neutral-600 dark:text-neutral-400 tracking-wider">Estimated Total</span>
                    <span class="font-serif text-2xl font-bold text-[#9E7D36] dark:text-[#D4AF37]">{{ $cart['formatted_subtotal'] }}</span>
                </div>

                <div class="space-y-3 pt-2">
                    <a href="{{ route('checkout.index') }}"
                       class="block w-full text-center py-4 btn-gold text-xs font-bold tracking-widest uppercase rounded-lg shadow-lg">
                        PROCEED TO CHECKOUT
                    </a>
                    <a href="{{ route('shop.catalog') }}"
                       class="block w-full text-center py-3 border border-neutral-300 dark:border-neutral-700 hover:border-neutral-500 text-neutral-700 dark:text-neutral-300 hover:text-black dark:hover:text-white hover:bg-neutral-50 dark:hover:bg-neutral-800 text-xs font-mono uppercase tracking-wider rounded-lg transition-colors">
                        Continue Shopping
                    </a>
                </div>

                <div class="pt-4 border-t border-neutral-200 dark:border-neutral-800/80 text-[11px] font-mono text-neutral-600 dark:text-neutral-400 space-y-2">
                    <div class="flex items-center gap-2 text-neutral-800 dark:text-neutral-300">
                        <span class="text-[#9E7D36] dark:text-[#D4AF37]">🔒</span>
                        <span>Encrypted Nigerian Payment Gateways</span>
                    </div>
                    <p class="text-[10px] leading-relaxed text-neutral-500">
                        Prices are verified server-side in Nigerian Naira. Your payment is authenticated via Paystack / Flutterwave 3D Secure protocols.
                    </p>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
