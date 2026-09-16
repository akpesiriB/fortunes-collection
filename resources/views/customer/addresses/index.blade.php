@extends('layouts.app')

@section('title', 'SAVED ADDRESSES | Fortunes Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <div class="flex items-center justify-between border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-4">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-widest mb-1">
                <a href="{{ route('customer.dashboard') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">Dashboard</a>
                <span>/</span>
                <span class="text-[#9E7D36] dark:text-[#D4AF37] font-bold">Addresses</span>
            </div>
            <h1 class="font-serif text-3xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">ADDRESS BOOK</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Saved Addresses (7 Cols) -->
        <div class="lg:col-span-7 space-y-4">
            <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white">YOUR DESTINATIONS</h2>
            @forelse($addresses as $addr)
                <div class="p-6 bg-white dark:bg-[#121212] border {{ $addr->is_default ? 'border-[#9E7D36] dark:border-[#D4AF37] ring-1 ring-[#9E7D36]/30 dark:ring-[#D4AF37]/30' : 'border-neutral-200 dark:border-neutral-800' }} rounded-xl space-y-2 font-mono text-xs shadow-sm">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-neutral-900 dark:text-white uppercase">{{ $addr->recipient_name }}</span>
                        @if($addr->is_default)
                            <span class="px-2 py-0.5 bg-[#9E7D36] dark:bg-[#D4AF37] text-white dark:text-black text-[9px] font-bold uppercase rounded">DEFAULT SHIPPING</span>
                        @endif
                    </div>
                    <p class="text-neutral-700 dark:text-neutral-300">{{ $addr->street_address }}</p>
                    @if($addr->apartment)
                        <p class="text-neutral-500 dark:text-neutral-400">{{ $addr->apartment }}</p>
                    @endif
                    <p class="text-neutral-500 dark:text-neutral-400">{{ $addr->city }}, {{ $addr->state }} ({{ $addr->lga }})</p>
                    <p class="text-neutral-500 dark:text-neutral-400">Phone: {{ $addr->phone }}</p>
                </div>
            @empty
                <div class="p-8 text-center bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl text-neutral-500 dark:text-neutral-400 font-mono text-xs shadow-sm">
                    No addresses recorded yet. Add your preferred delivery location.
                </div>
            @endforelse
        </div>

        <!-- Add Address Form (5 Cols) -->
        <div class="lg:col-span-5 bg-white dark:bg-[#141414] border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 space-y-4 shadow-sm">
            <h3 class="font-serif text-lg font-bold uppercase text-neutral-900 dark:text-white border-b border-neutral-200 dark:border-neutral-800 pb-3">
                ADD NEW ADDRESS
            </h3>

            <form action="{{ route('customer.addresses.store') }}" method="POST" class="space-y-3 font-mono text-xs">
                @csrf
                <div>
                    <label class="block text-neutral-600 dark:text-neutral-400 uppercase mb-1">Recipient Name</label>
                    <input type="text" name="recipient_name" required value="{{ old('recipient_name', auth()->user()->name) }}"
                           class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 p-2.5 text-neutral-900 dark:text-white rounded focus:outline-none focus:border-[#C5A059]">
                </div>
                <div>
                    <label class="block text-neutral-600 dark:text-neutral-400 uppercase mb-1">Phone Number</label>
                    <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="+234 800 000 0000"
                           class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 p-2.5 text-neutral-900 dark:text-white rounded focus:outline-none focus:border-[#C5A059]">
                </div>
                <div>
                    <label class="block text-neutral-600 dark:text-neutral-400 uppercase mb-1">Street Address</label>
                    <input type="text" name="street_address" required
                           class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 p-2.5 text-neutral-900 dark:text-white rounded focus:outline-none focus:border-[#C5A059]">
                </div>
                <div>
                    <label class="block text-neutral-600 dark:text-neutral-400 uppercase mb-1">Apartment / Suite</label>
                    <input type="text" name="apartment"
                           class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 p-2.5 text-neutral-900 dark:text-white rounded focus:outline-none focus:border-[#C5A059]">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-neutral-600 dark:text-neutral-400 uppercase mb-1">City</label>
                        <input type="text" name="city" required value="Effurun"
                               class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 p-2.5 text-neutral-900 dark:text-white rounded focus:outline-none focus:border-[#C5A059]">
                    </div>
                    <div>
                        <label class="block text-neutral-600 dark:text-neutral-400 uppercase mb-1">State</label>
                        <select name="state" required class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 p-2.5 text-neutral-900 dark:text-white rounded focus:outline-none focus:border-[#C5A059]">
                            <option value="Delta" selected>Delta</option>
                            <option value="Edo">Edo</option>
                            <option value="Rivers">Rivers</option>
                            <option value="Abuja FCT">Abuja FCT</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-neutral-600 dark:text-neutral-400 uppercase mb-1">LGA</label>
                    <input type="text" name="lga" placeholder="e.g. Uvwie"
                           class="w-full bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 p-2.5 text-neutral-900 dark:text-white rounded focus:outline-none focus:border-[#C5A059]">
                </div>
                <label class="flex items-center gap-2 pt-2 text-neutral-700 dark:text-neutral-300 cursor-pointer">
                    <input type="checkbox" name="is_default" value="1" checked class="text-[#9E7D36] dark:text-[#D4AF37]">
                    <span>Set as primary delivery address</span>
                </label>
                <button type="submit" class="w-full py-3 btn-gold text-xs font-bold uppercase rounded mt-2">
                    Save Address
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
