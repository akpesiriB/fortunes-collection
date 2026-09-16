@extends('layouts.app')

@section('title', $product->name . ' | FORTUNES COLLECTION')
@section('meta_description', Str::limit($product->short_description ?? $product->description, 160))
@section('meta_image', $product->featured_image)

@section('content')
<!-- Product Schema (JSON-LD) -->
<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "{{ $product->name }}",
    "image": "{{ $product->featured_image }}",
    "description": "{{ $product->short_description }}",
    "sku": "{{ $product->sku }}",
    "brand": {
        "@type": "Brand",
        "name": "Fortunes Collection"
    },
    "offers": {
        "@type": "Offer",
        "url": "{{ url()->current() }}",
        "priceCurrency": "NGN",
        "price": "{{ $product->price }}",
        "availability": "{{ $product->is_sold_out ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock' }}",
        "itemCondition": "https://schema.org/NewCondition"
    }
}
</script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16"
     x-data="{
        selectedVariantId: '{{ $product->variants->first()?->id }}',
        selectedSize: '{{ $product->variants->first()?->size }}',
        selectedColor: '{{ $product->variants->first()?->color }}',
        selectedStock: {{ $product->variants->first()?->stock_quantity ?? 0 }},
        quantity: 1,
        activeImage: '{{ $product->featured_image }}',
        activeTab: 'details',
        adding: false,

        submitToCart() {
            if (this.selectedStock <= 0) return;
            this.adding = true;
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: {{ $product->id }},
                    variant_id: this.selectedVariantId,
                    quantity: this.quantity
                })
            })
            .then(r => r.json())
            .then(data => {
                this.adding = false;
                const bodyEl = document.querySelector('body');
                if (bodyEl && bodyEl._x_dataStack) {
                    const app = bodyEl._x_dataStack[0];
                    app.fetchCartData();
                    app.cartDrawerOpen = true;
                    app.notify('Added ' + this.quantity + ' item(s) to Bag');
                }
            })
            .catch(() => {
                this.adding = false;
                window.location.href = '{{ route('cart.index') }}';
            });
        }
     }">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 font-mono text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-widest">
        <a href="{{ route('shop.index') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">Home</a>
        <span>/</span>
        <a href="{{ route('shop.category', $product->category->slug) }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="text-[#9E7D36] dark:text-[#D4AF37] truncate">{{ $product->name }}</span>
    </div>

    <!-- Main Product Grid: Gallery + Details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Left: Image Gallery (7 Cols) -->
        <div class="lg:col-span-7 space-y-4">
            <!-- Main Display Image -->
            <div class="aspect-[3/4] bg-[#FAF7F2] dark:bg-[#121212] border-2 border-[#C5A059]/30 dark:border-[#D4AF37]/30 rounded-2xl overflow-hidden relative shadow-xl dark:shadow-2xl flex items-center justify-center p-4">
                <img :src="activeImage" :alt="'{{ $product->name }}'"
                     class="w-full h-full object-contain object-center transition-all duration-300">
                
                @if($product->is_sold_out)
                    <div class="absolute top-4 left-4 px-4 py-2 bg-neutral-900/90 dark:bg-black/80 backdrop-blur-md border border-neutral-600 text-white font-mono text-xs font-bold uppercase tracking-widest rounded-lg shadow">
                        ARCHIVE PIECE SOLD OUT
                    </div>
                @endif
            </div>

            <!-- Thumbnail Carousel -->
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $img)
                        <button type="button" @click="activeImage = '{{ $img->image_path }}'"
                                class="aspect-[3/4] rounded-lg overflow-hidden border transition-all p-1 bg-[#FAF7F2] dark:bg-[#121212]"
                                :class="activeImage === '{{ $img->image_path }}' ? 'border-[#9E7D36] ring-1 ring-[#9E7D36] dark:border-[#D4AF37] dark:ring-[#D4AF37]' : 'border-neutral-300 dark:border-neutral-800 hover:border-neutral-500 dark:hover:border-neutral-600'">
                            <img src="{{ $img->image_path }}" alt="Thumbnail" class="w-full h-full object-contain">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Product Specifications & Order Form (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="space-y-2 border-b border-neutral-200 dark:border-neutral-800 pb-6">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] uppercase tracking-[0.25em] font-bold">
                        {{ $product->subtitle ?? $product->category->name }}
                    </span>
                    <span class="font-mono text-xs text-neutral-500 uppercase tracking-widest">
                        SKU: {{ $product->sku }}
                    </span>
                </div>
                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-neutral-900 dark:text-white uppercase tracking-tight">
                    {{ $product->name }}
                </h1>
                <div class="flex items-center gap-4 pt-2">
                    <span class="font-mono text-2xl font-bold text-neutral-900 dark:text-white">
                        {{ $product->formatted_price }}
                    </span>
                    @if($product->compare_at_price)
                        <span class="font-mono text-sm text-neutral-500 line-through">
                            {{ $product->formatted_compare_at_price }}
                        </span>
                    @endif
                    <span class="px-2.5 py-0.5 bg-[#F2ECE1] dark:bg-[#1A1A1A] border border-[#9E7D36]/30 dark:border-[#D4AF37]/30 text-[#9E7D36] dark:text-[#D4AF37] text-[10px] font-mono uppercase tracking-widest rounded-full">
                        EFFURUN HANDCRAFTED
                    </span>
                </div>
            </div>

            <!-- Short Description -->
            <p class="text-xs sm:text-sm text-neutral-700 dark:text-neutral-300 leading-relaxed font-sans">
                {{ $product->short_description ?? $product->description }}
            </p>

            <!-- Order Form -->
            <form @submit.prevent="submitToCart()" class="space-y-6 pt-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" :value="selectedVariantId">

                <!-- Variant: Size Selection -->
                @if($product->variants->isNotEmpty())
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs font-mono uppercase tracking-wider">
                            <span class="text-neutral-600 dark:text-neutral-400">SELECT SIZE:</span>
                            <span class="text-[#9E7D36] dark:text-[#D4AF37]" x-text="selectedSize"></span>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->variants as $v)
                                <button type="button"
                                        @click="selectedVariantId = '{{ $v->id }}'; selectedSize = '{{ $v->size }}'; selectedColor = '{{ $v->color }}'; selectedStock = {{ $v->stock_quantity }}"
                                        class="py-3 font-mono text-xs uppercase tracking-wider rounded-lg border transition-all flex flex-col items-center justify-center {{ $v->stock_quantity <= 0 ? 'opacity-40 cursor-not-allowed border-dashed' : '' }}"
                                        :class="selectedVariantId == '{{ $v->id }}' ? 'bg-gradient-to-r from-[#F0DEB8] via-[#C5A059] to-[#9E7D36] text-black border-[#C5A059] font-bold shadow-md' : 'bg-white dark:bg-[#141414] text-neutral-800 dark:text-neutral-300 border-neutral-300 dark:border-neutral-700 hover:border-[#9E7D36] dark:hover:border-[#D4AF37]'">
                                    <span>{{ $v->size }}</span>
                                    @if($v->stock_quantity <= 0)
                                        <span class="text-[9px] text-red-500">Sold</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Real-time Stock indicator -->
                <div class="font-mono text-xs flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full" :class="selectedStock > 0 ? 'bg-emerald-500 animate-pulse' : 'bg-red-500'"></span>
                    <span :class="selectedStock > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500 dark:text-red-400'"
                          x-text="selectedStock > 0 ? 'IN ARCHIVE ⬝ ' + selectedStock + ' PIECES AVAILABLE' : 'CURRENTLY SOLD OUT'"></span>
                </div>

                <!-- Quantity & Add to Bag Buttons -->
                <div class="flex items-center gap-3 pt-2">
                    <div class="flex items-center border border-neutral-300 dark:border-neutral-700 rounded-lg overflow-hidden bg-white dark:bg-[#141414]">
                        <button type="button" @click="quantity = Math.max(1, quantity - 1)"
                                class="px-4 py-3.5 text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white bg-neutral-100 dark:bg-neutral-800 text-sm font-mono">-</button>
                        <input type="number" name="quantity" x-model="quantity" min="1"
                               class="w-14 bg-transparent text-center text-sm font-mono text-neutral-900 dark:text-white focus:outline-none" readonly>
                        <button type="button" @click="quantity = Math.min(selectedStock || 10, quantity + 1)"
                                class="px-4 py-3.5 text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white bg-neutral-100 dark:bg-neutral-800 text-sm font-mono">+</button>
                    </div>

                    @if(!$product->is_sold_out)
                        <button type="submit"
                                :disabled="adding || selectedStock <= 0"
                                class="flex-1 py-4 btn-gold text-xs font-bold tracking-widest rounded-lg flex items-center justify-center gap-2 shadow-xl active:scale-95 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span x-text="adding ? 'RESERVING...' : 'ADD TO ARCHIVE BAG'">ADD TO ARCHIVE BAG</span>
                        </button>
                    @else
                        <button type="button" disabled
                                class="flex-1 py-4 bg-neutral-200 dark:bg-neutral-800 text-neutral-500 font-mono text-xs font-bold tracking-widest rounded-lg uppercase cursor-not-allowed">
                            SOLD OUT IN ATELIER
                        </button>
                    @endif

                    <!-- Wishlist Button -->
                    <button type="button"
                            @click="toggleWishlist({{ $product->id }})"
                            class="p-4 bg-white dark:bg-[#141414] hover:bg-neutral-100 dark:hover:bg-[#202020] border border-neutral-300 dark:border-neutral-700 hover:border-[#9E7D36] dark:hover:border-[#D4AF37] rounded-lg text-neutral-700 dark:text-neutral-300 hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-all shadow-sm"
                            title="Save to Wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Luxury Guarantees Strip -->
            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-800 font-mono text-[11px] text-neutral-600 dark:text-neutral-400">
                <div class="flex items-center gap-2">
                    <span class="text-[#9E7D36] dark:text-[#D4AF37]">✓</span>
                    <span>Effurun Same-Day Delivery</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[#9E7D36] dark:text-[#D4AF37]">✓</span>
                    <span>18k Gold Plated Hardware</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[#9E7D36] dark:text-[#D4AF37]">✓</span>
                    <span>Paystack / Flutterwave</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[#9E7D36] dark:text-[#D4AF37]">✓</span>
                    <span>Collector Gift Packaging</span>
                </div>
            </div>

            <!-- Haute Accordion Details -->
            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-6 space-y-4">
                
                <!-- Tab: Details -->
                <div class="border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden bg-white dark:bg-[#121212] shadow-sm">
                    <button @click="activeTab = activeTab === 'details' ? '' : 'details'"
                            class="w-full p-4 flex justify-between items-center text-xs font-mono font-bold uppercase tracking-wider text-neutral-900 dark:text-white hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">
                        <span>SILHOUETTE SPECIFICATIONS</span>
                        <span x-text="activeTab === 'details' ? '−' : '+'" class="text-sm"></span>
                    </button>
                    <div x-show="activeTab === 'details'" class="p-4 pt-0 text-xs text-neutral-700 dark:text-neutral-300 font-mono whitespace-pre-line leading-relaxed border-t border-neutral-100 dark:border-neutral-800/60 mt-2">
                        {{ $product->details ?? $product->description }}
                    </div>
                </div>

                <!-- Tab: Care -->
                <div class="border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden bg-white dark:bg-[#121212] shadow-sm">
                    <button @click="activeTab = activeTab === 'care' ? '' : 'care'"
                            class="w-full p-4 flex justify-between items-center text-xs font-mono font-bold uppercase tracking-wider text-neutral-900 dark:text-white hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">
                        <span>FABRIC & ATELIER CARE</span>
                        <span x-text="activeTab === 'care' ? '−' : '+'" class="text-sm"></span>
                    </button>
                    <div x-show="activeTab === 'care'" class="p-4 pt-0 text-xs text-neutral-700 dark:text-neutral-300 font-mono whitespace-pre-line leading-relaxed border-t border-neutral-100 dark:border-neutral-800/60 mt-2">
                        {{ $product->care_instructions ?? 'Dry clean recommended to preserve vintage garment wash and metallic hardware.' }}
                    </div>
                </div>

                <!-- Tab: Shipping -->
                <div class="border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden bg-white dark:bg-[#121212] shadow-sm">
                    <button @click="activeTab = activeTab === 'shipping' ? '' : 'shipping'"
                            class="w-full p-4 flex justify-between items-center text-xs font-mono font-bold uppercase tracking-wider text-neutral-900 dark:text-white hover:text-[#9E7D36] dark:hover:text-[#D4AF37]">
                        <span>NIGERIAN & GLOBAL DISPATCH</span>
                        <span x-text="activeTab === 'shipping' ? '−' : '+'" class="text-sm"></span>
                    </button>
                    <div x-show="activeTab === 'shipping'" class="p-4 pt-0 text-xs text-neutral-700 dark:text-neutral-300 font-mono space-y-2 border-t border-neutral-100 dark:border-neutral-800/60 mt-2">
                        <p>• <strong>Effurun & Warri VIP:</strong> Same-day dispatch for orders placed before 2pm WAT (₦3,500).</p>
                        <p>• <strong>Delta State & Regional Express:</strong> 24-48 hours delivery via dedicated courier (₦4,500).</p>
                        <p>• <strong>Nationwide Priority Air:</strong> 2-3 business days nationwide to Abuja, Port Harcourt, and state capitals (₦7,500).</p>
                        <p>• <strong>Complimentary Shipping:</strong> Automatically applied for orders over ₦500,000.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Verified Collector Reviews Section -->
    <div class="border-t border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pt-12 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <span class="font-mono text-xs tracking-[0.25em] text-[#9E7D36] dark:text-[#D4AF37] uppercase">VERIFIED REVIEWS</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold uppercase text-neutral-900 dark:text-white">COLLECTOR APPRAISALS</h2>
            </div>
            <div class="flex items-center gap-2 font-mono text-sm text-[#9E7D36] dark:text-[#D4AF37]">
                <span>★★★★★</span>
                <span class="text-neutral-900 dark:text-white font-bold">{{ $product->average_rating }} / 5.0</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($product->reviews as $r)
                <div class="p-6 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-3 shadow-sm">
                    <div class="flex justify-between items-center">
                        <span class="font-mono text-xs font-bold text-[#9E7D36] dark:text-[#D4AF37] uppercase">{{ $r->author_name }}</span>
                        <span class="text-[10px] font-mono text-emerald-700 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800/60 bg-emerald-50 dark:bg-emerald-950/40 px-2 py-0.5 rounded">VERIFIED PURCHASE</span>
                    </div>
                    <h4 class="font-serif text-base font-bold text-neutral-900 dark:text-white uppercase">{{ $r->title }}</h4>
                    <p class="text-xs text-neutral-700 dark:text-neutral-300 leading-relaxed font-sans">{{ $r->comment }}</p>
                </div>
            @empty
                <div class="col-span-2 text-center py-10 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl text-neutral-600 dark:text-neutral-400 font-mono text-xs shadow-sm">
                    Be the first collector to review this silhouette upon delivery.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="border-t border-neutral-200 dark:border-neutral-800 pt-12 space-y-8">
            <h2 class="font-serif text-2xl font-bold uppercase text-neutral-900 dark:text-white tracking-wide">COMPLETE THE FIT</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <x-product-card :product="$rel" />
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
