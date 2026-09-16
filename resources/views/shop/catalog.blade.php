@extends('layouts.app')

@section('title', 'ARCHIVE CATALOG | Fortunes Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-6 gap-4">
        <div>
            <div class="flex items-center gap-2 font-mono text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-widest mb-1">
                <a href="{{ route('shop.index') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">Home</a>
                <span>/</span>
                @if(isset($activeCollection) && $activeCollection)
                    <span class="text-red-500 dark:text-red-400 font-bold">Hot Series</span>
                    <span>/</span>
                    <span class="text-[#9E7D36] dark:text-[#D4AF37]">{{ $activeCollection->name }}</span>
                @else
                    <span class="text-[#9E7D36] dark:text-[#D4AF37]">{{ $activeCategory ? $activeCategory->name : 'All Silhouettes' }}</span>
                @endif
            </div>
            <h1 class="font-serif text-3xl sm:text-5xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight">
                @if(isset($activeCollection) && $activeCollection)
                    <span class="block text-red-500 dark:text-red-400 font-mono text-xs tracking-[0.25em] font-bold mb-1">HOT SERIES DROP</span>
                    {{ $activeCollection->name }}
                @elseif($activeCategory)
                    {{ $activeCategory->name }}
                @else
                    THE FULL ARCHIVE
                @endif
            </h1>
        </div>

        <span class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] tracking-widest uppercase">
            Showing {{ $products->total() }} Numbered Silhouettes
        </span>
    </div>

    <!-- Filter & Sort Bar -->
    <div class="bg-white dark:bg-[#121212] border border-[#C5A059]/30 dark:border-[#C5A059]/25 p-3.5 sm:p-4 rounded-2xl flex flex-wrap items-center justify-between gap-4 shadow-[0_4px_20px_rgba(0,0,0,0.04)] dark:shadow-xl">
        
        <!-- Category Filter Pills with Active Silhouette Icons -->
        <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0 scrollbar-none" style="-webkit-overflow-scrolling: touch;">
            <a href="{{ route('shop.catalog') }}"
               class="px-3.5 py-2 shrink-0 rounded-full font-mono text-[11px] sm:text-xs uppercase tracking-wider transition-all flex items-center gap-2 {{ !$activeCategory && !request('category') ? 'bg-gradient-to-r from-[#F0DEB8] via-[#C5A059] to-[#9E7D36] text-black font-bold shadow-[0_2px_12px_rgba(197,160,89,0.3)]' : 'bg-[#F2ECE1] text-neutral-700 hover:text-black border border-neutral-300 hover:border-[#9E7D36] dark:bg-[#181818] dark:text-neutral-300 dark:hover:text-white dark:border-neutral-700 dark:hover:border-[#C5A059]/50' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span>All ({{ \App\Models\Product::active()->count() }})</span>
            </a>
            @foreach($categories as $cat)
                @php
                    $isCatActive = ($activeCategory && $activeCategory->id === $cat->id) || request('category') === $cat->slug;
                    $isTops = strtolower($cat->slug) === 'tops';
                    $isBottoms = strtolower($cat->slug) === 'bottoms';
                    $isOuter = str_contains(strtolower($cat->slug), 'outer') || str_contains(strtolower($cat->slug), 'under');
                @endphp
                <a href="{{ route('shop.category', $cat->slug) }}"
                   class="px-3.5 py-2 shrink-0 rounded-full font-mono text-[11px] sm:text-xs uppercase tracking-wider transition-all flex items-center gap-2 {{ $isCatActive ? 'bg-gradient-to-r from-[#F0DEB8] via-[#C5A059] to-[#9E7D36] text-black font-bold shadow-[0_2px_12px_rgba(197,160,89,0.3)]' : 'bg-[#F2ECE1] text-neutral-700 hover:text-black border border-neutral-300 hover:border-[#9E7D36] dark:bg-[#181818] dark:text-neutral-300 dark:hover:text-white dark:border-neutral-700 dark:hover:border-[#C5A059]/50' }}">
                    @if($isTops)
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 8l3.5-3h2a2.5 2.5 0 0 0 5 0h2l3.5 3-2 3-2-1v9a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 6 19v-9L4 11 4 8z" />
                        </svg>
                    @elseif($isBottoms)
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M6 3h12a1 1 0 0 1 1 1v4.5l-2.2 11.5a1 1 0 0 1-1 .8h-3a1 1 0 0 1-1-.9L12 11l-.8 8.9a1 1 0 0 1-1 .9H7.2a1 1 0 0 1-1-.8L4 8.5V4a1 1 0 0 1 1-1z" />
                        </svg>
                    @elseif($isOuter)
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 6.5l4-3.5h8l4 3.5v13.5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6.5z" />
                        </svg>
                    @else
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="7.5" />
                        </svg>
                    @endif
                    <span>{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>

        <!-- Sort Dropdown -->
        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 w-full sm:w-auto justify-end">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            @if(request('collection'))
                <input type="hidden" name="collection" value="{{ request('collection') }}">
            @endif
            <label for="sort" class="font-mono text-xs uppercase text-neutral-600 dark:text-neutral-400">Sort:</label>
            <select name="sort" id="sort" onchange="this.form.submit()"
                    class="bg-[#FAF8F5] dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 text-xs font-mono uppercase tracking-wider px-3.5 py-2 rounded-xl focus:outline-none focus:border-[#C5A059] shadow-sm">
                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest Drops</option>
                <option value="bestseller" {{ $sort === 'bestseller' ? 'selected' : '' }}>Best Sellers</option>
                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
        </form>
    </div>

    <!-- Active Search & Series Filter Badges -->
    @if((isset($activeCollection) && $activeCollection) || request('search'))
        <div class="flex flex-wrap items-center gap-2 font-mono text-xs">
            @if(isset($activeCollection) && $activeCollection)
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-500/10 dark:bg-red-950/40 border border-red-500/30 text-red-600 dark:text-red-400 font-bold">
                    <span>🔥 HOT SERIES: {{ $activeCollection->name }}</span>
                    <a href="{{ route('shop.catalog', array_filter(['category' => request('category'), 'sort' => request('sort')])) }}" class="hover:text-red-700 dark:hover:text-white text-base leading-none font-normal" title="Remove filter">&times;</a>
                </div>
            @endif
            @if(request('search'))
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#9E7D36]/10 border border-[#9E7D36]/30 text-[#9E7D36] dark:text-[#D4AF37] font-bold">
                    <span>Search: "{{ request('search') }}"</span>
                    <a href="{{ route('shop.catalog', array_filter(['collection' => request('collection'), 'category' => request('category'), 'sort' => request('sort')])) }}" class="hover:text-red-500 text-base leading-none font-normal" title="Clear search">&times;</a>
                </div>
            @endif
            <a href="{{ route('shop.catalog') }}" class="text-neutral-500 hover:text-red-500 hover:underline text-[11px] ml-2">Clear all filters</a>
        </div>
    @endif

    <!-- Product Grid: 2-Cols on Mobile Phone, Scaling to 5-Cols on Large Screens -->
    <div class="grid grid-cols-2 gap-3.5 sm:gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @forelse($products as $product)
            <x-product-card :product="$product" />
        @empty
            <div class="col-span-full text-center py-20 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-2xl shadow-sm">
                <p class="font-serif text-2xl text-neutral-900 dark:text-white">No silhouettes found in this category.</p>
                <p class="text-xs text-neutral-600 dark:text-neutral-400 font-mono mt-2">Adjust your filters or view the entire archive.</p>
                <a href="{{ route('shop.catalog') }}" class="inline-block mt-4 px-6 py-3 btn-gold text-xs">Reset Filters</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-8">
        {{ $products->links() }}
    </div>
</div>
@endsection
