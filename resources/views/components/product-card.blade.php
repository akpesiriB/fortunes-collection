@props([
    'product',
    'class' => '',
])

<div class="group relative rounded-[28px] border-2 border-neutral-200 hover:border-[#9E7D36] dark:border-white/75 dark:hover:border-[#D4AF37] bg-white dark:bg-neutral-900 overflow-hidden aspect-[3/4.4] transition-all duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.06)] hover:shadow-[0_12px_32px_rgba(158,125,54,0.18)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.5)] dark:hover:shadow-[0_16px_45px_rgba(0,0,0,0.7)] hover:-translate-y-1 select-none {{ $class }}">

    <!-- Product Image with Generous Padding Framed Inside Studio Background -->
    <div class="absolute inset-0 p-3 sm:p-4 pb-14 sm:pb-16 flex items-center justify-center overflow-hidden bg-white dark:bg-neutral-900 transition-colors duration-300">
        <img src="{{ str_starts_with($product->featured_image, 'http') ? $product->featured_image : asset(ltrim($product->featured_image, '/')) }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="w-full h-full object-contain object-center group-hover:scale-105 transition-transform duration-500 ease-out">
    </div>

    <!-- Seamless Card Click Overlay (Navigates to Product Page) -->
    <a href="{{ route('shop.show', $product->slug) }}"
       class="absolute inset-0 z-10"
       aria-label="View {{ $product->name }}"></a>

    <!-- Bottom Gradient Scrim (Alabaster White in Light Mode / Deep Obsidian Noir in Dark Mode) -->
    <div class="absolute inset-x-0 bottom-0 h-24 sm:h-28 bg-gradient-to-t from-white via-white/80 to-transparent dark:from-black/95 dark:via-black/50 dark:to-transparent pointer-events-none z-[1] transition-colors duration-300"></div>

    <!-- Top Left: Status Badges (NEW / SOLD OUT) -->
    <div class="absolute top-2.5 left-2.5 sm:top-3 sm:left-3 flex flex-col gap-1 z-20 pointer-events-none">
        @if($product->is_sold_out)
            <span class="px-2 py-0.5 bg-neutral-900 text-white dark:bg-black/80 dark:border dark:border-white/25 font-mono text-[8px] sm:text-[9px] font-bold uppercase tracking-widest rounded-full shadow">
                SOLD OUT
            </span>
        @elseif($product->is_new)
            <span class="px-2 py-0.5 bg-gradient-to-r from-[#F0DEB8] via-[#C5A059] to-[#9E7D36] text-black font-mono text-[8px] sm:text-[9px] font-extrabold uppercase tracking-widest rounded-full shadow-sm">
                NEW
            </span>
        @endif
    </div>

    <!-- Top Right: Wishlist Button -->
    <button type="button"
            @click.prevent.stop="toggleWishlist({{ $product->id }})"
            class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 z-20 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/85 hover:bg-white text-neutral-800 border border-neutral-300 hover:border-[#9E7D36] hover:text-[#9E7D36] dark:bg-black/50 dark:hover:bg-black/90 dark:text-white dark:border-white/25 dark:hover:border-[#D4AF37] dark:hover:text-[#D4AF37] flex items-center justify-center transition-all duration-200 active:scale-90 shadow-sm"
            title="Add to Wishlist"
            aria-label="Save to Wishlist">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>

    <!-- Bottom Content Information Block -->
    <div class="absolute bottom-0 inset-x-0 p-2.5 sm:p-3.5 z-20 flex flex-col pointer-events-none">
        
        <!-- Product Name -->
        <a href="{{ route('shop.show', $product->slug) }}"
           class="pointer-events-auto block transition-colors">
            <h3 class="font-sans font-bold text-neutral-900 group-hover:text-[#9E7D36] dark:text-white dark:group-hover:text-[#F5E6C4] text-xs sm:text-sm tracking-tight leading-tight dark:drop-shadow-[0_2px_4px_rgba(0,0,0,1)] line-clamp-1 transition-colors">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Description: Subtitle / snippet -->
        <p class="text-[9.5px] sm:text-[11px] text-neutral-600 dark:text-[#E5E7EB] font-sans font-normal leading-tight line-clamp-1 dark:drop-shadow-[0_1px_3px_rgba(0,0,0,1)] mt-0.5 mb-1.5 sm:mb-2 transition-colors">
            {{ $product->subtitle ?? ($product->short_description ?: ($product->description ? Str::limit(strip_tags($product->description), 45) : $product->category->name)) }}
        </p>

        <!-- Footer Row: Left (Price), Right (Cart Icon Button - No Text) -->
        <div class="flex items-center justify-between gap-2 pt-1 sm:pt-1.5 border-t border-neutral-200 dark:border-white/20 transition-colors">
            
            <!-- Left: Price -->
            <div class="flex items-baseline gap-1.5 flex-wrap">
                <span class="font-mono font-bold text-[#8C6D28] dark:text-[#F5E6C4] text-xs sm:text-sm tracking-tight dark:drop-shadow-[0_1px_3px_rgba(0,0,0,1)] transition-colors">
                    {{ $product->formatted_price }}
                </span>
                @if($product->compare_at_price)
                    <span class="font-mono text-[9px] sm:text-[10px] text-neutral-600 line-through">
                        {{ $product->formatted_compare_at_price }}
                    </span>
                @endif
            </div>

            <!-- Right: Cart Icon Button -->
            <div class="pointer-events-auto shrink-0">
                @if(!$product->is_sold_out)
                    <button type="button"
                            @click.prevent.stop="quickAddToCart({{ $product->id }}, {{ $product->variants->first()?->id ?? 'null' }})"
                            class="w-6 h-6 sm:w-7 sm:h-7 bg-neutral-900 hover:bg-[#9E7D36] text-white dark:bg-white dark:hover:bg-[#D4AF37] dark:text-black rounded-full transition-all duration-200 shadow-md active:scale-90 flex items-center justify-center cursor-pointer"
                            title="Add to Cart"
                            aria-label="Add to Cart">
                        <svg class="w-3.5 h-3.5 text-white dark:text-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </button>
                @else
                    <span class="px-2 py-0.5 bg-neutral-100 text-neutral-600 border border-neutral-300 dark:bg-black/80 dark:text-neutral-300 dark:border-neutral-600 backdrop-blur-sm font-mono text-[8px] uppercase tracking-wider rounded-full">
                        Sold Out
                    </span>
                @endif
            </div>
        </div>

    </div>

</div>
