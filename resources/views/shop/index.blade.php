@extends('layouts.app')

@section('title', 'FORTUNES COLLECTION | Haute Nigerian Streetwear')

@section('content')
<div class="space-y-16 pb-20">

    <!-- 1. Cinematic Haute Hero (Exact Reference Recreation: Fortunes Collection Effurun) -->
    <section id="haute-hero"
             x-data="heroCinematic()"
             @mousemove="onMouseMove($event)"
             @mouseleave="onMouseLeave()"
             class="relative w-full min-h-[92vh] sm:min-h-[88vh] lg:min-h-screen bg-[#070707] text-white flex flex-col justify-between overflow-hidden select-none">

        <!-- Master Background Visual Layer: 8K Retouched Invisible Mannequin Outfit & Natural Volumetric Spotlight -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <img src="{{ asset('images/hero-master.jpg') }}"
                 alt="Fortunes Collection Haute Luxury Streetwear"
                 class="w-full h-full object-cover object-[72%_center] sm:object-[65%_center] lg:object-[center_35%] transition-transform duration-700 ease-out"
                 :style="'transform: scale(1.02) translate3d(' + (mouseX * -8) + 'px, ' + (mouseY * -8) + 'px, 0)'">

            <!-- Responsive Luxury Vignette: Vertical on mobile to showcase center outfit brightly; horizontal on desktop -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#070707]/90 via-[#070707]/30 to-[#070707]/90 lg:bg-gradient-to-r lg:from-[#070707]/90 lg:via-[#070707]/25 lg:to-transparent pointer-events-none"></div>

            <!-- Soft, Ethereal Atmospheric Light Glow Highlighting the Clothes (Subtle & Diffuse Per Reference) -->
            <div class="absolute inset-0 z-10 pointer-events-none overflow-hidden mix-blend-screen"
                 :style="'transform: translate3d(' + (mouseX * 8) + 'px, ' + (mouseY * 8) + 'px, 0)'">
                <div class="absolute top-[20%] right-[-10%] sm:right-[10%] lg:right-[18%] w-[420px] sm:w-[520px] h-[420px] sm:h-[520px] rounded-full blur-[90px] sm:blur-[110px] opacity-70"
                     style="background: radial-gradient(circle, rgba(245, 230, 196, 0.14) 0%, rgba(197, 160, 89, 0.06) 45%, transparent 75%);"></div>
            </div>

            <!-- Gentle bottom atmospheric fade into catalog -->
            <div class="absolute bottom-0 inset-x-0 h-24 bg-gradient-to-t from-[#070707] via-[#070707]/50 to-transparent pointer-events-none"></div>
        </div>

        <!-- Top-Left Architectural Corner Accent with Specular Gold Edge (Per Exact Reference Image) -->
        <div class="absolute top-0 left-0 w-60 sm:w-88 md:w-[440px] h-48 sm:h-72 md:h-[340px] pointer-events-none z-10 overflow-hidden">
            <div class="absolute inset-0 bg-[#070707]/85" style="clip-path: polygon(0 0, 100% 0, 0 100%);"></div>
            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="cornerGoldRim" x1="100%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="#FFF8E7" stop-opacity="0.95" />
                        <stop offset="30%" stop-color="#D4AF37" stop-opacity="0.8" />
                        <stop offset="70%" stop-color="#C5A059" stop-opacity="0.35" />
                        <stop offset="100%" stop-color="#C5A059" stop-opacity="0" />
                    </linearGradient>
                    <filter id="goldGlow" x="-20%" y="-20%" width="140%" height="140%">
                        <feGaussianBlur stdDeviation="1.2" result="blur" />
                        <feMerge>
                            <feMergeNode in="blur" />
                            <feMergeNode in="SourceGraphic" />
                        </feMerge>
                    </filter>
                </defs>
                <line x1="100" y1="0" x2="0" y2="100" stroke="url(#cornerGoldRim)" stroke-width="0.75" filter="url(#goldGlow)" />
            </svg>
        </div>

        <!-- Live Golden Dust Sparkles Canvas (Drifting Gently in the Atmospheric Light) -->
        <canvas id="hero-particles-canvas" class="absolute inset-0 z-15 pointer-events-none w-full h-full opacity-75"></canvas>

        <!-- TOP BAR: Brandmark on Left + Mobile Quick Controls on Right -->
        <div class="relative z-30 max-w-7xl mx-auto w-full px-4 sm:px-10 lg:px-12 pt-6 sm:pt-10 flex items-center justify-between">
            <div class="flex items-center gap-3 sm:gap-3.5">
                <div class="w-8 h-8 sm:w-10 sm:h-10 border border-[#C5A059]/80 flex items-center justify-center bg-black/50 backdrop-blur-md shadow-[0_0_12px_rgba(197,160,89,0.25)]">
                    <span class="font-serif text-xs sm:text-sm font-bold text-[#F5E6C4]">FC</span>
                </div>
                <div class="font-serif tracking-[0.24em] uppercase">
                    <span class="block text-white font-medium text-[10.5px] sm:text-xs tracking-[0.24em]">FORTUNES</span>
                    <span class="text-[8px] sm:text-[9.5px] text-[#C5A059] tracking-[0.3em] block font-mono font-medium">COLLECTION · EFFURUN</span>
                </div>
            </div>
            
            <!-- Mobile Quick Actions (Discreet luxury buttons for phone screens) -->
            <div class="flex items-center gap-2 lg:hidden">
                <button @click="openCartDrawer()" class="p-2 text-[#C5A059] hover:text-[#F5E6C4] relative" title="Shopping Bag">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span x-show="cartCount > 0" class="absolute top-1 right-1 w-2 h-2 rounded-full bg-[#C5A059] animate-pulse"></span>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-[#C5A059] hover:text-[#F5E6C4]" aria-label="Toggle navigation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- MAIN LEFT EDITORIAL TYPOGRAPHY (Proportionally matched to reference image) -->
        <div class="relative z-30 max-w-7xl mx-auto w-full px-6 sm:px-10 lg:px-12 my-auto py-8 sm:py-12 grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <div class="lg:col-span-7 space-y-2.5 sm:space-y-3">
                
                <!-- Tagline with Gold Line: WHERE PASSION MEETS FASHION (Per Instruction) -->
                <div class="flex items-center gap-3">
                    <span class="w-7 sm:w-9 h-[1px] bg-[#C5A059]"></span>
                    <span class="font-mono text-[9px] sm:text-[10px] tracking-[0.28em] text-[#C5A059] uppercase font-semibold">
                        WHERE PASSION MEETS FASHION
                    </span>
                </div>

                <!-- Grand Title: FORTUNES (Reduced to match reference proportions) -->
                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl lg:text-[56px] font-normal tracking-[0.16em] uppercase leading-[1.0] text-[#FAF8F5] drop-shadow-[0_2px_18px_rgba(0,0,0,0.8)]">
                    FORTUNES
                </h1>

                <!-- Subheading: COLLECTION (Warm Metallic Champagne Gold Serif Per Reference) -->
                <h2 class="font-serif text-base sm:text-lg md:text-xl lg:text-2xl tracking-[0.42em] uppercase font-medium"
                    style="background-image: linear-gradient(135deg, #F5E6C4 0%, #D4AF37 40%, #B8934A 75%, #8C6D28 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    COLLECTION
                </h2>

                <!-- Location: EFFURUN (Effurun and Effurun Only) -->
                <p class="font-mono text-[9px] sm:text-[10px] tracking-[0.55em] text-[#C5A059] uppercase font-medium pt-0.5">
                    EFFURUN
                </p>

                <!-- Clean Haute Action Buttons (Reduced width & padding per instruction) -->
                <div class="pt-3 sm:pt-5 flex flex-wrap items-center gap-3">
                    <a href="#store-catalog"
                       class="px-5 py-2 sm:px-6 sm:py-2.5 bg-gradient-to-r from-[#F0DEB8] via-[#C5A059] to-[#9E7D36] hover:brightness-105 text-black font-mono font-bold text-[9.5px] sm:text-[10px] uppercase tracking-[0.16em] rounded-full shadow-[0_2px_12px_rgba(197,160,89,0.25)] hover:shadow-[0_4px_18px_rgba(197,160,89,0.4)] active:scale-95 transition-all inline-flex items-center gap-1.5">
                        <span>EXPLORE COLLECTION</span>
                        <span class="text-xs">↓</span>
                    </a>
                    <a href="{{ route('shop.catalog') }}"
                       class="px-5 py-2 sm:px-6 sm:py-2.5 bg-black/60 hover:bg-black/85 text-neutral-200 hover:text-white font-mono font-semibold text-[9.5px] sm:text-[10px] uppercase tracking-[0.16em] rounded-full border border-[#C5A059]/40 hover:border-[#C5A059] backdrop-blur-md shadow-md transition-all">
                        NEW ARRIVALS ⬝
                    </a>
                </div>
            </div>

            <!-- Empty right column allowing the illuminated outfit to dominate visually -->
            <div class="hidden lg:block lg:col-span-5"></div>
        </div>

        <!-- ==========================================================================
             DYNAMIC FLOATING PARTICLES SYSTEM SURROUNDING THE CLOTHES
             (All elements surrounding hoodie, pants, cap & shoes floating dynamically)
             ========================================================================== -->
        <div class="absolute inset-0 z-20 pointer-events-none overflow-hidden max-md:scale-90 origin-top-right">
            
            <!-- 1. Draped Black Silk Fabric Fragment (Floating Above Cap) -->
            <div class="absolute particle-float-1 transition-transform duration-500 ease-out"
                 :style="'transform: translate3d(' + (mouseX * -32) + 'px, ' + (mouseY * -32) + 'px, 0)'"
                 style="top: 8%; right: 14%; sm:right: 23%;">
                <img src="{{ asset('images/particles/cloth_drape.png') }}"
                     alt="Floating silk drape"
                     class="w-16 sm:w-28 lg:w-32 h-auto opacity-95 drop-shadow-[0_10px_25px_rgba(212,175,55,0.35)]">
            </div>

            <!-- 2. Floating Sleeve Cuff #1 (Upper Left of Hoodie) -->
            <div class="absolute particle-float-3 transition-transform duration-500 ease-out hidden sm:block"
                 :style="'transform: translate3d(' + (mouseX * 38) + 'px, ' + (mouseY * -24) + 'px, 0)'"
                 style="top: 24%; right: 46%;">
                <img src="{{ asset('images/particles/cloth_cuff_top.png') }}"
                     alt="Floating sleeve cuff"
                     class="w-12 sm:w-16 h-auto opacity-90 drop-shadow-[0_8px_20px_rgba(212,175,55,0.4)]">
            </div>

            <!-- 3. Floating Sleeve Cuff #2 (Mid Left of Hoodie) -->
            <div class="absolute particle-float-2 transition-transform duration-500 ease-out hidden sm:block"
                 :style="'transform: translate3d(' + (mouseX * -28) + 'px, ' + (mouseY * 26) + 'px, 0)'"
                 style="top: 48%; right: 45%;">
                <img src="{{ asset('images/particles/cloth_cuff_mid.png') }}"
                     alt="Floating cuff"
                     class="w-10 sm:w-14 h-auto opacity-90 drop-shadow-[0_8px_18px_rgba(212,175,55,0.4)]">
            </div>

            <!-- 4. Floating Dark Sleeve / Glove (Lower Left Void) -->
            <div class="absolute particle-float-4 transition-transform duration-500 ease-out hidden md:block"
                 :style="'transform: translate3d(' + (mouseX * 35) + 'px, ' + (mouseY * 30) + 'px, 0)'"
                 style="top: 57%; right: 43%;">
                <img src="{{ asset('images/particles/cloth_sleeve.png') }}"
                     alt="Floating dark sleeve"
                     class="w-14 sm:w-20 h-auto opacity-95 drop-shadow-[0_10px_24px_rgba(212,175,55,0.45)]">
            </div>

            <!-- 5. Mini Folded Golden Tee (Drifting Below Hoodie) -->
            <div class="absolute particle-float-1 transition-transform duration-500 ease-out"
                 :style="'transform: translate3d(' + (mouseX * -22) + 'px, ' + (mouseY * 34) + 'px, 0)'"
                 style="bottom: 22%; right: 18%; sm:right: 35%;">
                <img src="{{ asset('images/particles/cloth_mini_shirt.png') }}"
                     alt="Floating gold tee silhouette"
                     class="w-10 sm:w-16 h-auto opacity-95 drop-shadow-[0_8px_22px_rgba(212,175,55,0.5)]">
            </div>

            <!-- 6. Floating Cuff near Sneakers (Bottom Center-Right) -->
            <div class="absolute particle-float-2 transition-transform duration-500 ease-out"
                 :style="'transform: translate3d(' + (mouseX * 32) + 'px, ' + (mouseY * -20) + 'px, 0)'"
                 style="bottom: 14%; right: 15%; sm:right: 23%;">
                <img src="{{ asset('images/particles/cloth_cuff_shoe.png') }}"
                     alt="Floating cuff near sneaker"
                     class="w-11 sm:w-18 h-auto opacity-90 drop-shadow-[0_8px_20px_rgba(212,175,55,0.4)]">
            </div>

            <!-- 7. Twisting Golden Satin Ribbon Swatch (Lower Right) -->
            <div class="absolute particle-ribbon transition-transform duration-500 ease-out"
                 :style="'transform: translate3d(' + (mouseX * -36) + 'px, ' + (mouseY * -18) + 'px, 0)'"
                 style="bottom: 16%; right: 2%; sm:right: 4%;">
                <img src="{{ asset('images/particles/ribbon_gold.png') }}"
                     alt="Golden satin ribbon"
                     class="w-28 sm:w-48 lg:w-56 h-auto opacity-95 drop-shadow-[0_10px_30px_rgba(212,175,55,0.5)]">
            </div>

            <!-- 8. Floating Miniature Golden Hardware / Hanger (Upper Right) -->
            <div class="absolute particle-float-3 transition-transform duration-500 ease-out"
                 :style="'transform: translate3d(' + (mouseX * 25) + 'px, ' + (mouseY * -28) + 'px, 0)'"
                 style="top: 20%; right: 4%; sm:right: 6%;">
                <img src="{{ asset('images/particles/hardware_hanger.png') }}"
                     alt="Golden hardware"
                     class="w-8 sm:w-14 h-auto opacity-95 drop-shadow-[0_6px_18px_rgba(212,175,55,0.6)]">
            </div>

            <!-- 9. 3D Metallic 18K Gold Coin #1 (Upper Sky Drift) -->
            <div class="absolute particle-coin transition-transform duration-500 ease-out"
                 :style="'transform: translate3d(' + (mouseX * -20) + 'px, ' + (mouseY * -25) + 'px, 0)'"
                 style="top: 9%; right: 5%; sm:right: 7%;">
                <img src="{{ asset('images/particles/coin_top_right.png') }}"
                     alt="18K Gold Coin"
                     class="w-5 sm:w-9 h-auto drop-shadow-[0_0_15px_rgba(212,175,55,0.8)]">
            </div>

            <!-- 10. 3D Metallic Gold Coin #2 (Mid Left Floating Mote) -->
            <div class="absolute particle-coin transition-transform duration-500 ease-out hidden sm:block"
                 :style="'transform: translate3d(' + (mouseX * 28) + 'px, ' + (mouseY * 18) + 'px, 0)'"
                 style="top: 44%; right: 48%;">
                <img src="{{ asset('images/particles/coin_left.png') }}"
                     alt="Gold Coin"
                     class="w-6 sm:w-8 h-auto drop-shadow-[0_0_14px_rgba(212,175,55,0.75)]">
            </div>

            <!-- 11. 3D Metallic Gold Coin #3 (Mid Right Sky) -->
            <div class="absolute particle-coin transition-transform duration-500 ease-out"
                 :style="'transform: translate3d(' + (mouseX * -24) + 'px, ' + (mouseY * 22) + 'px, 0)'"
                 style="top: 56%; right: 4%; sm:right: 6%;">
                <img src="{{ asset('images/particles/coin_mid_right.png') }}"
                     alt="Gold Coin"
                     class="w-6 sm:w-10 h-auto drop-shadow-[0_0_16px_rgba(212,175,55,0.8)]">
            </div>

            <!-- 12. Soft Golden Bokeh Orbs (Creating Cinematic Depth of Field) -->
            <div class="absolute particle-bokeh pointer-events-none"
                 style="bottom: 8%; right: 25%; sm:right: 43%;">
                <img src="{{ asset('images/particles/bokeh_orb_1.png') }}"
                     alt="Golden Bokeh Orb"
                     class="w-16 sm:w-28 h-auto opacity-80 filter blur-[1px]">
            </div>
            <div class="absolute particle-bokeh pointer-events-none"
                 style="bottom: 11%; right: 8%; sm:right: 11%; animation-delay: 2.8s;">
                <img src="{{ asset('images/particles/bokeh_orb_2.png') }}"
                     alt="Golden Bokeh Orb"
                     class="w-16 sm:w-26 h-auto opacity-75 filter blur-[1.5px]">
            </div>

            <!-- 13. High-Definition 18K Monogram Gold Emblems Floating in Space -->
            <div class="absolute w-4 h-4 sm:w-5 sm:h-5 rounded-full border border-[#FFF3CE] bg-gradient-to-br from-[#FFEAA3] to-[#8C6D28] shadow-[0_0_16px_rgba(212,175,55,0.8)] top-1/3 right-1/4 sm:right-1/3 particle-float-1 flex items-center justify-center font-mono text-[7px] sm:text-[8px] text-black font-extrabold tracking-tighter">FC</div>
            <div class="absolute w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full border border-[#FFF3CE] bg-gradient-to-br from-[#FFEAA3] to-[#8C6D28] shadow-[0_0_14px_rgba(212,175,55,0.7)] bottom-1/3 right-1/6 sm:right-1/4 particle-float-3 flex items-center justify-center font-mono text-[6px] sm:text-[7px] text-black font-extrabold tracking-tighter">18K</div>
            <div class="absolute w-3 h-3 sm:w-3.5 sm:h-3.5 rounded-full border border-[#FFF3CE] bg-gradient-to-br from-[#FFEAA3] to-[#8C6D28] shadow-[0_0_12px_rgba(212,175,55,0.65)] top-1/2 right-1/6 sm:right-1/5 particle-float-2"></div>
            <div class="absolute w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full border border-[#FFF3CE] bg-[#D4AF37] shadow-[0_0_10px_rgba(212,175,55,0.65)] bottom-1/5 right-1/4 sm:right-1/3 particle-float-4"></div>

            <!-- 14. Luminous Golden Dust Motes Catching Specular Light -->
            <div class="absolute w-2 sm:w-2.5 h-2 sm:h-2.5 rounded-full bg-[#FFF5D6] shadow-[0_0_18px_#D4AF37] top-1/4 right-1/4 sm:right-1/3 particle-float-1 opacity-90"></div>
            <div class="absolute w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-[#FFEAA3] shadow-[0_0_14px_#D4AF37] bottom-1/3 right-1/3 sm:right-1/2 particle-float-3 opacity-80"></div>
            <div class="absolute w-2.5 sm:w-3 h-2.5 sm:h-3 rounded-full bg-[#FFF4D0] shadow-[0_0_20px_#D4AF37] top-1/2 right-1/5 sm:right-1/4 particle-float-2 opacity-85"></div>
            <div class="absolute w-1.5 h-1.5 rounded-full bg-white shadow-[0_0_12px_#D4AF37] bottom-1/4 right-1/6 sm:right-1/5 particle-float-4 opacity-95"></div>
            <div class="absolute w-2 h-2 rounded-full bg-[#FFF3CE] shadow-[0_0_16px_#D4AF37] top-1/6 right-1/6 sm:right-1/5 particle-float-1 opacity-85"></div>
            <div class="absolute w-2 sm:w-2.5 h-2 sm:h-2.5 rounded-full bg-[#FFE899] shadow-[0_0_14px_#D4AF37] top-3/4 right-1/10 sm:right-1/8 particle-float-3 opacity-85"></div>
        </div>
    </section>

    <!-- Anchor for Smooth Scroll Transition -->
    <div id="store-catalog" class="scroll-mt-32 pt-4"></div>

    <!-- Category Strips (HAUTE SILHOUETTE MATRIX: TOPS, BOTTOMS, OUTERWEAR, ACCESSORIES) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($categories as $cat)
                @php
                    $isTops = strtolower($cat->slug) === 'tops';
                    $isBottoms = strtolower($cat->slug) === 'bottoms';
                    $isOuterwear = str_contains(strtolower($cat->slug), 'outer') || str_contains(strtolower($cat->slug), 'under');
                    $isAccessories = str_contains(strtolower($cat->slug), 'access');
                @endphp
                <a href="{{ route('shop.category', $cat->slug) }}"
                   class="group relative p-3.5 sm:p-5 bg-white dark:bg-gradient-to-br dark:from-[#161616] dark:via-[#101010] dark:to-[#070707] border border-[#C5A059]/30 dark:border-[#C5A059]/25 hover:border-[#9E7D36] dark:hover:border-[#C5A059] rounded-2xl flex items-center justify-between transition-all duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.04)] dark:shadow-[0_4px_20px_rgba(0,0,0,0.5)] hover:shadow-[0_6px_28px_rgba(197,160,89,0.22)] hover:-translate-y-0.5 overflow-hidden">
                    
                    <!-- Ambient Specular Glow on Hover -->
                    <div class="absolute -right-10 -bottom-10 w-28 h-28 rounded-full bg-[#C5A059]/10 blur-2xl group-hover:bg-[#C5A059]/20 transition-all pointer-events-none"></div>

                    <div class="flex items-center gap-3 sm:gap-4 relative z-10 min-w-0">
                        <!-- Bespoke Active Silhouette Medallion -->
                        <div class="w-11 h-11 sm:w-13 sm:h-13 shrink-0 rounded-xl bg-[#F7F4EE] border border-[#C5A059]/30 text-[#9E7D36] group-hover:text-black group-hover:border-[#9E7D36] group-hover:bg-[#C5A059]/20 group-hover:scale-105 dark:bg-black/70 dark:border-[#C5A059]/40 dark:text-[#C5A059] dark:group-hover:text-[#F5E6C4] dark:group-hover:border-[#C5A059] dark:group-hover:bg-[#C5A059]/15 transition-all duration-300 shadow-inner flex items-center justify-center">
                            @if($isTops)
                                <!-- Active Haute Top / Hoodie Silhouette -->
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 8l3.5-3h2a2.5 2.5 0 0 0 5 0h2l3.5 3-2 3-2-1v9a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 6 19v-9L4 11 4 8z" />
                                    <path d="M9.5 5a2.5 2.5 0 0 0 5 0" stroke-width="1.6" stroke="#C5A059" />
                                    <line x1="12" y1="9" x2="12" y2="12" stroke-width="1.4" stroke="#C5A059" />
                                </svg>
                            @elseif($isBottoms)
                                <!-- Active Tailored Trouser / Cargo Pants Silhouette -->
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 3h12a1 1 0 0 1 1 1v4.5l-2.2 11.5a1 1 0 0 1-1 .8h-3a1 1 0 0 1-1-.9L12 11l-.8 8.9a1 1 0 0 1-1 .9H7.2a1 1 0 0 1-1-.8L4 8.5V4a1 1 0 0 1 1-1z" />
                                    <line x1="6" y1="7" x2="18" y2="7" stroke-width="1.2" stroke-dasharray="2 1.5" stroke="#C5A059" />
                                    <line x1="12" y1="3" x2="12" y2="7" stroke-width="1.4" stroke="#C5A059" />
                                </svg>
                            @elseif($isOuterwear)
                                <!-- Active Haute Kimono / Bonded Jacket Silhouette -->
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 6.5l4-3.5h8l4 3.5v13.5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6.5z" />
                                    <path d="M8 3v18M16 3v18" stroke-width="1.2" stroke="#C5A059" />
                                    <line x1="12" y1="8" x2="12" y2="21" stroke-width="1.8" stroke="#C5A059" />
                                    <circle cx="12" cy="7.5" r="1" fill="#C5A059" />
                                </svg>
                            @else
                                <!-- Active 18K Hardware / Signet & Accessories Silhouette -->
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="7.5" stroke-width="1.6" />
                                    <polygon points="12,7 13.8,10.2 17.5,10.4 14.8,13 15.6,16.6 12,14.6 8.4,16.6 9.2,13 6.5,10.4 10.2,10.2" fill="none" stroke="#C5A059" stroke-width="1.2" />
                                    <circle cx="12" cy="12" r="2.2" fill="#C5A059" />
                                </svg>
                            @endif
                        </div>

                        <!-- Classy Editorial Typography -->
                        <div class="min-w-0">
                            <h3 class="font-serif text-sm sm:text-base font-bold uppercase tracking-[0.16em] text-neutral-900 group-hover:text-[#9E7D36] dark:text-white dark:group-hover:text-[#F5E6C4] transition-colors truncate">
                                {{ $cat->name }}
                            </h3>
                            <span class="font-mono text-[8.5px] sm:text-[9.5px] text-[#8C6D28] dark:text-[#C5A059] tracking-[0.24em] uppercase flex items-center gap-1 mt-0.5">
                                <span>SERIES</span>
                                <span class="text-neutral-400 dark:text-neutral-500">·</span>
                                <span class="text-neutral-600 group-hover:text-black dark:text-neutral-400 dark:group-hover:text-white transition-colors">EXPLORE</span>
                            </span>
                        </div>
                    </div>

                    <!-- Ambient Gold Arrow Indicator -->
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-neutral-100 border border-neutral-200 text-neutral-600 group-hover:border-[#9E7D36]/60 group-hover:bg-[#9E7D36]/10 group-hover:text-[#9E7D36] group-hover:translate-x-0.5 dark:bg-white/5 dark:border-white/10 dark:text-neutral-400 dark:group-hover:text-[#F5E6C4] transition-all duration-300 shrink-0 ml-2 flex items-center justify-center">
                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- 2. Product Carousel: "NEW" / "ARCHIVE" (Sized Per Adidas Reference) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data="{
                 scrollProgress: 0,
                 canScrollLeft: false,
                 canScrollRight: true,
                 updateScroll() {
                     const el = this.$refs.carousel;
                     if (!el) return;
                     const maxScroll = el.scrollWidth - el.clientWidth;
                     this.scrollProgress = maxScroll > 0 ? (el.scrollLeft / maxScroll) * 100 : 0;
                     this.canScrollLeft = el.scrollLeft > 10;
                     this.canScrollRight = el.scrollLeft < maxScroll - 10;
                 },
                 scroll(direction) {
                     const el = this.$refs.carousel;
                     if (!el) return;
                     el.scrollBy({ left: direction * 300, behavior: 'smooth' });
                 }
             }"
             x-init="$nextTick(() => updateScroll())">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-4 mb-6 gap-4">
            <div>
                <span class="font-mono text-xs tracking-[0.3em] text-[#9E7D36] dark:text-[#D4AF37] uppercase">2026 ARCHIVE SILHOUETTES</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight text-neutral-900 dark:text-white uppercase mt-1">NEW ARRIVALS</h2>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('shop.catalog') }}" class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] hover:underline uppercase tracking-widest flex items-center gap-2">
                    <span>VIEW FULL CATALOG ({{ \App\Models\Product::active()->count() }})</span>
                    <span>→</span>
                </a>
                
                <!-- Carousel Nav Controls -->
                <div class="hidden sm:flex items-center gap-2">
                    <button @click="scroll(-1)"
                            :disabled="!canScrollLeft"
                            :class="!canScrollLeft ? 'opacity-30 cursor-not-allowed' : 'hover:border-[#9E7D36] dark:hover:border-[#D4AF37] hover:text-[#9E7D36] dark:hover:text-[#D4AF37] active:scale-95'"
                            class="w-9 h-9 rounded-full border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-[#141414] text-neutral-800 dark:text-white flex items-center justify-center transition-all shadow-sm"
                            aria-label="Scroll left">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="scroll(1)"
                            :disabled="!canScrollRight"
                            :class="!canScrollRight ? 'opacity-30 cursor-not-allowed' : 'hover:border-[#9E7D36] dark:hover:border-[#D4AF37] hover:text-[#9E7D36] dark:hover:text-[#D4AF37] active:scale-95'"
                            class="w-9 h-9 rounded-full border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-[#141414] text-neutral-800 dark:text-white flex items-center justify-center transition-all shadow-sm"
                            aria-label="Scroll right">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Horizontal Scrollable Track -->
        <div class="relative group">
            <div x-ref="carousel"
                 @scroll.passive="updateScroll()"
                 class="flex gap-4 sm:gap-5 overflow-x-auto scroll-smooth snap-x snap-mandatory hide-scrollbar pb-4 pt-1 px-1 -mx-1">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" class="w-[260px] sm:w-[285px] md:w-[295px] flex-shrink-0 snap-start" />
                @endforeach
            </div>

            <!-- Horizontal Scroll Progress Pill Track (Per Reference Screenshot) -->
            <div class="mt-4 flex items-center justify-center">
                <div class="w-48 sm:w-64 h-1 bg-neutral-200 dark:bg-neutral-800 rounded-full overflow-hidden relative">
                    <div class="h-full bg-[#9E7D36] dark:bg-[#D4AF37] rounded-full transition-all duration-150"
                         :style="'width: 35%; margin-left: ' + (scrollProgress * 0.65) + '%'"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Hot Series: Fastest-Selling Luxury Brands Spotlight -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-4 mb-8 gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-500/10 dark:bg-red-950/40 border border-red-500/30 text-red-600 dark:text-red-400 font-mono text-[10px] tracking-[0.25em] uppercase font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-ping"></span>
                        HIGH HEAT • FASTEST-SELLING BRANDS
                    </span>
                </div>
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-neutral-900 dark:text-white uppercase mt-2">HOT SERIES</h2>
                <p class="text-xs sm:text-sm text-neutral-600 dark:text-neutral-400 max-w-2xl mt-1.5 leading-relaxed font-sans">
                    The atelier's highest-velocity drops and fastest-selling luxury brand edits — from iconic houses like Gucci to high-heat avant-garde street series.
                </p>
            </div>

            <a href="{{ route('shop.catalog') }}" class="font-mono text-xs uppercase tracking-widest text-[#9E7D36] dark:text-[#D4AF37] hover:underline flex items-center gap-1 shrink-0 font-bold">
                <span>View Full Archive</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featuredCollections as $col)
                @php
                    $colImages = [
                        'gucci-series' => 'https://images.unsplash.com/photo-1548883354-7622d03aca27?q=80&w=1200&auto=format&fit=crop',
                        'balenciaga-series' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1200&auto=format&fit=crop',
                        'casablanca-series' => 'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=1200&auto=format&fit=crop',
                        'genesis-archive' => 'https://images.unsplash.com/photo-1548883354-7622d03aca27?q=80&w=1200&auto=format&fit=crop',
                        'effurun-nocturne' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1200&auto=format&fit=crop',
                        'cyber-sahara' => 'https://images.unsplash.com/photo-1552374196-1ab2a1c593e8?q=80&w=1200&auto=format&fit=crop',
                    ];
                    $bgImg = $col->banner_image ?? ($colImages[$col->slug] ?? 'https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=800&auto=format&fit=crop');
                @endphp
                <div class="group relative rounded-2xl overflow-hidden bg-neutral-900 border border-neutral-200 dark:border-neutral-800 hover:border-[#9E7D36] dark:hover:border-[#D4AF37] transition-all p-7 sm:p-8 flex flex-col justify-between min-h-[360px] shadow-lg dark:shadow-2xl">
                    <!-- Photographic Background with Vignette & Scale -->
                    <div class="absolute inset-0 z-0 overflow-hidden">
                        <img src="{{ $bgImg }}" alt="{{ $col->name }}"
                             class="w-full h-full object-cover object-center opacity-40 group-hover:opacity-55 group-hover:scale-110 transition-all duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-black/30"></div>
                    </div>

                    <div class="flex items-center justify-between gap-2 z-10 relative">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-black/80 backdrop-blur-md border border-[#D4AF37]/50 rounded-full font-mono text-[10px] text-[#F5E6C4] tracking-[0.2em] uppercase font-bold">
                            <svg class="w-3 h-3 text-red-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.527.82-1.157 2.052-1.397 3.328C8.163 6.012 7.74 5.56 7.24 5.097a1 1 0 00-1.637.766c-.035 1.224.237 2.477.868 3.513.626 1.026 1.57 1.83 2.66 2.302A6.98 6.98 0 019 14a7 7 0 1014 0c0-1.785-.668-3.414-1.777-4.654-.537-.6-1.196-1.127-1.897-1.634-.526-.381-1.076-.757-1.603-1.17-.677-.529-1.22-1.144-1.328-1.989z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $col->season }}</span>
                        </span>
                        <span class="text-[10px] font-mono text-neutral-400 uppercase tracking-widest bg-black/60 px-2 py-0.5 rounded border border-white/10">
                            BRAND SERIES
                        </span>
                    </div>

                    <div class="space-y-2.5 z-10 relative mt-6">
                        <h3 class="font-serif text-2xl sm:text-3xl font-bold text-white uppercase tracking-tight group-hover:text-[#F5E6C4] transition-colors drop-shadow-md">{{ $col->name }}</h3>
                        <p class="text-xs text-neutral-200 leading-relaxed font-sans line-clamp-2 drop-shadow-sm">{{ $col->tagline }}</p>
                    </div>

                    <div class="pt-6 border-t border-white/20 flex items-center justify-between z-10 relative mt-6">
                        <span class="font-mono text-xs text-neutral-300 uppercase font-semibold flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                            {{ $col->products_count }} Silhouettes In Demand
                        </span>
                        <a href="{{ route('shop.catalog', ['collection' => $col->slug]) }}"
                           class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-white/10 hover:bg-[#D4AF37] hover:text-black border border-white/20 hover:border-[#D4AF37] text-xs font-mono font-bold tracking-widest text-[#F5E6C4] hover:text-black transition-all uppercase group-hover:translate-x-0.5">
                            <span>Shop Hot Drop</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. Haute Testimonials & Verified Collectors -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-[#101010] border border-[#C5A059]/30 rounded-2xl p-8 md:p-12 shadow-[0_4px_20px_rgba(0,0,0,0.04)] dark:shadow-xl">
            <div class="max-w-3xl mx-auto text-center space-y-3 mb-10">
                <span class="font-mono text-xs tracking-[0.3em] text-[#9E7D36] dark:text-[#D4AF37] uppercase">VOICES OF THE ATELIER</span>
                <h2 class="font-serif text-3xl font-bold text-neutral-900 dark:text-white uppercase">COLLECTOR VOICES</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($testimonials as $t)
                    <div class="p-6 bg-[#FAF7F2] dark:bg-[#161616] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-4 shadow-sm">
                        <div class="flex items-center gap-1 text-[#9E7D36] dark:text-[#D4AF37] text-xs">
                            ★★★★★
                        </div>
                        <p class="font-serif text-lg italic text-neutral-800 dark:text-neutral-200 leading-relaxed">
                            "{{ $t->quote }}"
                        </p>
                        <div class="flex items-center gap-3 pt-3 border-t border-neutral-200 dark:border-neutral-800">
                            <img src="{{ $t->avatar }}" alt="{{ $t->author_name }}" class="w-10 h-10 rounded-full object-cover border border-[#9E7D36]/40 dark:border-[#D4AF37]/40">
                            <div>
                                <h4 class="font-mono text-xs font-bold uppercase text-neutral-900 dark:text-white">{{ $t->author_name }}</h4>
                                <span class="font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">{{ $t->author_title }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    function heroCinematic() {
        return {
            mouseX: 0,
            mouseY: 0,
            targetMouseX: 0,
            targetMouseY: 0,
            animationFrameId: null,

            init() {
                // Smooth Lerp animation loop for 60fps parallax
                const animateParallax = () => {
                    this.mouseX += (this.targetMouseX - this.mouseX) * 0.08;
                    this.mouseY += (this.targetMouseY - this.mouseY) * 0.08;
                    this.animationFrameId = requestAnimationFrame(animateParallax);
                };
                animateParallax();

                // Listen to scroll to seamlessly reveal global navbar when scrolling past hero
                window.addEventListener('scroll', () => {
                    const scrollY = window.scrollY;
                    if (scrollY > 70) {
                        window.dispatchEvent(new CustomEvent('show-nav'));
                    } else if (scrollY < 30) {
                        window.dispatchEvent(new CustomEvent('hide-nav'));
                    }
                }, { passive: true });

                // Initialize Live Golden Dust Mote Canvas
                this.$nextTick(() => {
                    this.initGoldenDustCanvas();
                });
            },

            onMouseMove(e) {
                const rect = this.$el.getBoundingClientRect();
                this.targetMouseX = ((e.clientX - rect.left) / rect.width - 0.5);
                this.targetMouseY = ((e.clientY - rect.top) / rect.height - 0.5);
            },

            onMouseLeave() {
                this.targetMouseX = 0;
                this.targetMouseY = 0;
            },

            initGoldenDustCanvas() {
                const canvas = document.getElementById('hero-particles-canvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                let width = canvas.width = canvas.offsetWidth;
                let height = canvas.height = canvas.offsetHeight;

                window.addEventListener('resize', () => {
                    width = canvas.width = canvas.offsetWidth;
                    height = canvas.height = canvas.offsetHeight;
                }, { passive: true });

                // Create 50 golden dust particles clustered in the spotlight beam around clothes
                const particles = [];
                const particleCount = 50;

                for (let i = 0; i < particleCount; i++) {
                    particles.push({
                        // Bias position towards the right center where the beam & clothes are
                        x: width * (0.35 + Math.random() * 0.6),
                        y: height * (0.05 + Math.random() * 0.9),
                        radius: 0.8 + Math.random() * 2.2,
                        speedX: (Math.random() - 0.45) * 0.4,
                        speedY: (Math.random() - 0.2) * 0.5,
                        baseAlpha: 0.25 + Math.random() * 0.65,
                        alpha: 0.3,
                        pulseSpeed: 0.015 + Math.random() * 0.03,
                        pulseOffset: Math.random() * Math.PI * 2,
                        color: Math.random() > 0.3 ? '#D4AF37' : '#FFF4D0'
                    });
                }

                let time = 0;
                const render = () => {
                    ctx.clearRect(0, 0, width, height);
                    time += 0.02;

                    for (let i = 0; i < particles.length; i++) {
                        const p = particles[i];
                        p.x += p.speedX;
                        p.y += p.speedY;

                        // Wrap around borders
                        if (p.x < width * 0.3) p.x = width;
                        if (p.x > width) p.x = width * 0.3;
                        if (p.y < 0) p.y = height;
                        if (p.y > height) p.y = 0;

                        // Twinkle effect
                        const currentAlpha = p.baseAlpha + Math.sin(time + p.pulseOffset) * 0.2;
                        p.alpha = Math.max(0.1, Math.min(1, currentAlpha));

                        // Draw golden glowing mote
                        ctx.beginPath();
                        ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                        ctx.fillStyle = p.color;
                        ctx.globalAlpha = p.alpha;
                        ctx.shadowBlur = p.radius * 5;
                        ctx.shadowColor = '#D4AF37';
                        ctx.fill();
                    }

                    requestAnimationFrame(render);
                };
                render();
            }
        };
    }
</script>
@endpush
