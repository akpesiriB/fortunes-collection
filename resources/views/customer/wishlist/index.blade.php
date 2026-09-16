@extends('layouts.app')

@section('title', 'MY WISHLIST | Fortunes Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    
    <div class="border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-4">
        <span class="font-mono text-xs tracking-[0.3em] text-[#9E7D36] dark:text-[#D4AF37] uppercase font-bold">SAVED ARCHIVES</span>
        <h1 class="font-serif text-3xl sm:text-5xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight mt-1">YOUR WISHLIST</h1>
    </div>

    @if($items->isEmpty())
        <div class="p-16 text-center bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-3 shadow-sm">
            <div class="w-12 h-12 border border-[#9E7D36]/30 dark:border-[#D4AF37]/30 mx-auto flex items-center justify-center text-[#9E7D36] dark:text-[#D4AF37] rounded-full">
                ♡
            </div>
            <p class="font-serif text-xl text-neutral-900 dark:text-white">No silhouettes saved yet.</p>
            <p class="text-xs text-neutral-600 dark:text-neutral-400 font-mono">Heart items in the catalog to curate your private wishlist.</p>
            <a href="{{ route('shop.catalog') }}" class="inline-block mt-2 px-6 py-3 btn-gold text-xs font-bold tracking-widest">
                BROWSE ARCHIVE
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($items as $item)
                <x-product-card :product="$item->product" />
            @endforeach
        </div>
    @endif

</div>
@endsection
