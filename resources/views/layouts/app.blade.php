<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FORTUNES COLLECTION | Haute Nigerian Streetwear | Effurun')</title>
    <meta name="description" content="@yield('meta_description', 'Bespoke Nigerian luxury streetwear. Hand-tailored in Effurun with raw selvedge denim, heavy French terry, and 18k antique gold hardware.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Early Theme Detection to prevent theme flash -->
    <script>
        if (localStorage.getItem('fc_theme') === 'light') {
            document.documentElement.classList.add('light');
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        }
    </script>

    <!-- Open Graph & SEO -->
    <meta property="og:title" content="@yield('title', 'FORTUNES COLLECTION | Haute Nigerian Streetwear | Effurun')">
    <meta property="og:description" content="@yield('meta_description', 'Bespoke Nigerian luxury streetwear. Hand-tailored in Effurun with raw selvedge denim, heavy French terry, and 18k antique gold hardware.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-share.jpg'))">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Google Fonts & Tailwind CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Silkscreen:wght@400;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        gold: {
                            DEFAULT: '#D4AF37',
                            champagne: '#C5A059',
                            bright: '#F5E6C4',
                            light: '#FFF8E7',
                            cream: '#F0DEB8',
                            dark: '#8C6D28',
                            shadow: '#9E7D36',
                            muted: 'rgba(197, 160, 89, 0.25)',
                        },
                        obsidian: '#080808',
                        darkcard: '#121212',
                        cream: '#F5F2EB',
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', '"Playfair Display"', 'Georgia', 'serif'],
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                        pixel: ['"Silkscreen"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/fortunes.css') }}">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Fortunes Collection Effurun",
        "url": "{{ url('/') }}",
        "logo": "{{ url('/images/logo.png') }}",
        "sameAs": [
            "https://instagram.com/fortunescollection",
            "https://twitter.com/fortunesng"
        ],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Plot 12, PTI Road",
            "addressLocality": "Effurun",
            "addressRegion": "Delta",
            "postalCode": "330102",
            "addressCountry": "NG"
        }
    }
    </script>

    @livewireStyles
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#FAF8F5] text-neutral-900 dark:bg-[#080808] dark:text-[#F5F2EB] font-sans antialiased min-h-screen flex flex-col transition-colors duration-300"
      x-data="fortunesApp()">

    <!-- Global Navigation Container (Hidden during Hero session on Home, slides in when hero slides out) -->
    <div @if(request()->routeIs('shop.index'))
            class="fixed top-0 inset-x-0 z-40 transition-all duration-700 ease-out transform -translate-y-full opacity-0 pointer-events-none"
            :class="navVisible ? '!translate-y-0 !opacity-100 !pointer-events-auto' : '-translate-y-full opacity-0 pointer-events-none'"
         @else
            class="sticky top-0 z-40 transition-all duration-300"
         @endif>

        <!-- 1. Top Ticker Marquee Bar -->
        <div class="bg-[#121212] border-b border-[#D4AF37]/30 text-xs text-[#D4AF37] tracking-[0.2em] uppercase font-mono py-2.5 overflow-hidden select-none shadow-sm">
            <div class="animate-marquee whitespace-nowrap flex items-center gap-8 font-semibold">
                <span>FORTUNES COLLECTION EFFURUN</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>ELEGANCE AS A WAY OF LIFE</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>STYLE AS AN EXPRESSION OF YOUR INNER SELF</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>WHERE FASHION MEETS PASSION</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>TIMELESS STYLE, ENDLESS POSSIBILITIES</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>CLOTHES THAT SPEAK WITHOUT SAYING A WORD</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>FASHION FOR EVERY STORY</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>FORTUNES EFFURUN FLAGSHIP OPEN</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>COMPLIMENTARY EFFURUN SAME-DAY DISPATCH</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>ARCHIVE 2026 LIVE</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>FORTUNES COLLECTION EFFURUN</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>ELEGANCE AS A WAY OF LIFE</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>STYLE AS AN EXPRESSION OF YOUR INNER SELF</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>WHERE FASHION MEETS PASSION</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>TIMELESS STYLE, ENDLESS POSSIBILITIES</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>CLOTHES THAT SPEAK WITHOUT SAYING A WORD</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>FASHION FOR EVERY STORY</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>FORTUNES EFFURUN FLAGSHIP OPEN</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>COMPLIMENTARY EFFURUN SAME-DAY DISPATCH</span>
                <span class="text-[#D4AF37]/60">⬝</span>
                <span>ARCHIVE 2026 LIVE</span>
                <span class="text-[#D4AF37]/60">⬝</span>
            </div>
        </div>

        <!-- 2. Header & Main Navigation -->
        <header class="bg-[#FAF8F5]/95 dark:bg-[#080808]/95 backdrop-blur-md border-b border-[#C5A059]/20 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Mobile Menu Trigger -->
            <div class="flex items-center gap-4 lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-neutral-900 dark:text-white p-2 focus:outline-none" aria-label="Toggle navigation">
                    <svg class="w-6 h-6 text-[#9E7D36] dark:text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Brand Logo -->
            <a href="{{ route('shop.index') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 border border-[#9E7D36] dark:border-[#D4AF37] flex items-center justify-center bg-[#F0EDE6] dark:bg-[#111] group-hover:bg-[#D4AF37] transition-colors">
                    <span class="font-serif text-lg font-bold text-[#9E7D36] dark:text-[#D4AF37] group-hover:text-black transition-colors">FC</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-serif tracking-[0.25em] text-xl font-bold uppercase gold-gradient-text">FORTUNES</span>
                    <span class="font-mono text-[9px] tracking-[0.35em] text-neutral-600 dark:text-neutral-400 uppercase -mt-1">COLLECTION ⬝ EFFURUN</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-1 bg-[#F0EDE6] dark:bg-[#121212] p-1.5 border border-[#C5A059]/30 rounded-full">
                <a href="{{ route('shop.index') }}"
                   class="px-5 py-2 text-xs uppercase tracking-[0.2em] font-semibold transition-all rounded-full {{ request()->routeIs('shop.index') ? 'bg-[#D4AF37] text-black shadow-md' : 'text-neutral-700 hover:text-black hover:bg-white/60 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-800' }}">
                    Home
                </a>
                <a href="{{ route('shop.catalog') }}"
                   class="px-5 py-2 text-xs uppercase tracking-[0.2em] font-semibold transition-all rounded-full {{ request()->routeIs('shop.catalog') || request()->routeIs('shop.category') ? 'bg-[#D4AF37] text-black shadow-md' : 'text-neutral-700 hover:text-black hover:bg-white/60 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-800' }}">
                    Shop
                </a>
                <a href="{{ route('shop.category', 'tops') }}"
                   class="px-4 py-2 text-xs uppercase tracking-[0.2em] font-semibold transition-all rounded-full text-neutral-700 hover:text-black hover:bg-white/60 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-800">
                    Tops
                </a>
                <a href="{{ route('shop.category', 'bottoms') }}"
                   class="px-4 py-2 text-xs uppercase tracking-[0.2em] font-semibold transition-all rounded-full text-neutral-700 hover:text-black hover:bg-white/60 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-800">
                    Bottoms
                </a>
                <a href="{{ route('shop.category', 'outerwear') }}"
                   class="px-4 py-2 text-xs uppercase tracking-[0.2em] font-semibold transition-all rounded-full text-neutral-700 hover:text-black hover:bg-white/60 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-800">
                    Outerwear
                </a>
                <a href="{{ route('shop.maison') }}"
                   class="px-5 py-2 text-xs uppercase tracking-[0.2em] font-semibold transition-all rounded-full {{ request()->routeIs('shop.maison') ? 'bg-[#D4AF37] text-black shadow-md' : 'text-neutral-700 hover:text-black hover:bg-white/60 dark:text-neutral-300 dark:hover:text-white dark:hover:bg-neutral-800' }}">
                    Atelier
                </a>
            </nav>

            <!-- Utility Icons (Theme Toggle, Search, Wishlist, Account, Bag) -->
            <div class="flex items-center gap-2 sm:gap-3">
                
                <!-- Light / Dark Mode Toggle Button -->
                <button @click="toggleTheme()"
                        class="p-2 text-neutral-700 hover:text-[#9E7D36] dark:text-neutral-300 dark:hover:text-[#D4AF37] transition-colors rounded-full focus:outline-none"
                        :title="darkMode ? 'Switch to Light Elegance' : 'Switch to Dark Noir'"
                        aria-label="Toggle Theme">
                    <svg x-show="darkMode" class="w-5 h-5 text-[#F5D061]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg x-show="!darkMode" class="w-5 h-5 text-[#9F7B18]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Search Button -->
                <button @click="searchOpen = true" class="p-2 text-neutral-700 hover:text-[#9E7D36] dark:text-neutral-300 dark:hover:text-[#D4AF37] transition-colors" title="Search Archive">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- Wishlist -->
                <a href="{{ route('wishlist.index') }}" class="p-2 text-neutral-700 hover:text-[#9E7D36] dark:text-neutral-300 dark:hover:text-[#D4AF37] transition-colors relative" title="Wishlist">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </a>

                <!-- Account / Concierge -->
                @auth('web')
                    <a href="{{ route('customer.dashboard') }}" class="p-2 text-[#9E7D36] dark:text-[#D4AF37] hover:text-black dark:hover:text-white transition-colors" title="Collector Account">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                @else
                    <a href="{{ route('customer.login') }}" class="p-2 text-neutral-700 hover:text-[#9E7D36] dark:text-neutral-300 dark:hover:text-[#D4AF37] transition-colors" title="Sign In">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </a>
                @endauth

                <!-- Shopping Bag Drawer Trigger -->
                <button @click="openCartDrawer()"
                        class="flex items-center gap-2.5 bg-white hover:bg-neutral-100 text-[#9E7D36] border border-[#C5A059]/40 dark:bg-[#141414] dark:hover:bg-[#1c1c1c] dark:text-[#D4AF37] dark:border-[#D4AF37]/50 px-3.5 py-2 rounded-full transition-all group shadow-sm"
                        title="Shopping Bag">
                    <svg class="w-4 h-4 text-[#9E7D36] dark:text-[#D4AF37] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="font-mono text-xs font-bold text-neutral-900 dark:text-white" x-text="cartCount">{{ session('fortunes_cart') ? count(session('fortunes_cart')) : 0 }}</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden bg-[#FAF8F5] dark:bg-[#111] border-b border-[#C5A059]/30 px-6 py-6 space-y-3 shadow-xl">
            <a href="{{ route('shop.index') }}" class="block text-sm uppercase tracking-widest text-[#9E7D36] dark:text-[#D4AF37] font-semibold py-2">Home</a>
            <a href="{{ route('shop.catalog') }}" class="block text-sm uppercase tracking-widest text-neutral-800 dark:text-neutral-300 hover:text-black dark:hover:text-white py-2">Catalog</a>
            <a href="{{ route('shop.category', 'tops') }}" class="block text-sm uppercase tracking-widest text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white py-1 pl-4">⬝ Tops</a>
            <a href="{{ route('shop.category', 'bottoms') }}" class="block text-sm uppercase tracking-widest text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white py-1 pl-4">⬝ Bottoms</a>
            <a href="{{ route('shop.category', 'outerwear') }}" class="block text-sm uppercase tracking-widest text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white py-1 pl-4">⬝ Outerwear</a>
            <a href="{{ route('shop.category', 'accessories') }}" class="block text-sm uppercase tracking-widest text-neutral-600 dark:text-neutral-400 hover:text-black dark:hover:text-white py-1 pl-4">⬝ Accessories</a>
            <a href="{{ route('shop.maison') }}" class="block text-sm uppercase tracking-widest text-neutral-800 dark:text-neutral-300 hover:text-black dark:hover:text-white py-2">Effurun Atelier</a>
            
            <div class="py-2 flex items-center justify-between border-t border-b border-neutral-200 dark:border-neutral-800 my-2">
                <span class="text-xs uppercase tracking-widest text-neutral-600 dark:text-neutral-400 font-mono">Appearance</span>
                <button @click="toggleTheme()" class="flex items-center gap-2 px-3.5 py-1.5 bg-neutral-200 dark:bg-[#222] border border-[#9E7D36]/40 dark:border-[#D4AF37]/40 rounded-full text-xs font-mono text-[#9E7D36] dark:text-[#D4AF37] transition-all">
                    <span x-text="darkMode ? '☀️ Light' : '🌙 Dark'"></span>
                </button>
            </div>

            <div class="pt-2 flex items-center justify-between">
                @auth('web')
                    <a href="{{ route('customer.dashboard') }}" class="text-xs uppercase tracking-widest text-[#9E7D36] dark:text-[#D4AF37]">My Account</a>
                @else
                    <a href="{{ route('customer.login') }}" class="text-xs uppercase tracking-widest text-[#9E7D36] dark:text-[#D4AF37]">Sign In</a>
                @endauth
                <a href="{{ route('admin.login') }}" class="text-xs uppercase tracking-widest text-neutral-500 hover:text-neutral-700 dark:text-neutral-500 dark:hover:text-neutral-300">Staff Portal</a>
            </div>
        </div>
    </header>
    </div>

    <!-- 3. Flash Notifications -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-emerald-950/80 border border-emerald-600/50 text-emerald-200 px-4 py-3 rounded-lg flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-xs tracking-wider uppercase font-mono">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-red-950/80 border border-red-600/50 text-red-200 px-4 py-3 rounded-lg flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="text-xs tracking-wider uppercase font-mono">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-200">&times;</button>
            </div>
        </div>
    @endif

    <!-- 4. Page Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- 5. Interactive Slide-Out Cart Drawer -->
    <div x-show="cartDrawerOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        
        <!-- Backdrop -->
        <div x-show="cartDrawerOpen"
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="cartDrawerOpen = false"
             class="absolute inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <!-- Cart Drawer Panel -->
            <div x-show="cartDrawerOpen"
                 @click.away="cartDrawerOpen = false"
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-md bg-[#FAF8F5] dark:bg-[#101010] text-neutral-900 dark:text-white border-l border-[#C5A059]/30 flex flex-col shadow-2xl">
                
                <!-- Drawer Header -->
                <div class="p-6 border-b border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 border border-[#9E7D36] dark:border-[#D4AF37] flex items-center justify-center bg-black">
                            <span class="font-serif text-sm font-bold text-[#D4AF37]">FC</span>
                        </div>
                        <h2 class="font-serif text-lg tracking-[0.2em] font-bold uppercase gold-gradient-text">Your Archive Bag</h2>
                    </div>
                    <button @click="cartDrawerOpen = false" class="text-neutral-500 hover:text-black dark:text-neutral-400 dark:hover:text-white p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Free Shipping Progress -->
                <div class="px-6 py-4 bg-[#F0EDE6] dark:bg-[#151515] border-b border-neutral-200 dark:border-neutral-800">
                    <div class="flex justify-between text-xs tracking-wider uppercase font-mono mb-1.5">
                        <span class="text-neutral-700 dark:text-neutral-300">Effurun VIP Dispatch</span>
                        <span class="text-[#9E7D36] dark:text-[#D4AF37]" x-text="freeShippingText">Complimentary at ₦500,000</span>
                    </div>
                    <div class="w-full bg-neutral-300 dark:bg-neutral-800 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-[#9F7B18] via-[#D4AF37] to-[#F5D061] h-full transition-all duration-500"
                             :style="'width: ' + freeShippingPercent + '%'"></div>
                    </div>
                </div>

                <!-- Cart Items Feed -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <template x-if="cartItems.length === 0">
                        <div class="text-center py-16 space-y-4">
                            <div class="w-16 h-16 border border-[#C5A059]/40 mx-auto flex items-center justify-center text-[#9E7D36] dark:text-[#D4AF37] rounded-full">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <p class="font-serif text-lg text-neutral-800 dark:text-neutral-300">Your archive bag is empty</p>
                            <p class="text-xs text-neutral-500 font-mono tracking-wider">Explore our limited numbered silhouettes.</p>
                            <a href="{{ route('shop.catalog') }}" @click="cartDrawerOpen = false"
                               class="inline-block mt-4 px-6 py-2.5 btn-outline-gold text-xs">Explore Catalog</a>
                        </div>
                    </template>

                    <template x-for="item in cartItems" :key="item.key">
                        <div class="p-3 bg-white dark:bg-[#161616] border border-neutral-200 dark:border-neutral-800 rounded-lg flex gap-4 hover:border-[#D4AF37]/40 transition-colors shadow-sm">
                            <img :src="item.image" :alt="item.name" class="w-20 h-24 object-contain rounded bg-[#FBF9F5] dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 p-1">
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-serif text-sm font-semibold tracking-wide text-neutral-900 dark:text-white" x-text="item.name"></h4>
                                        <button @click="removeFromCart(item.key)" class="text-neutral-400 hover:text-red-500 text-sm ml-2">&times;</button>
                                    </div>
                                    <p class="text-[11px] text-[#9E7D36] dark:text-[#D4AF37] font-mono mt-0.5" x-text="item.variant_details || 'Standard Edition'"></p>
                                    <p class="font-mono text-xs text-neutral-600 dark:text-neutral-300 mt-1" x-text="item.formatted_price"></p>
                                </div>
                                <div class="flex items-center justify-between mt-2 pt-2 border-t border-neutral-200 dark:border-neutral-800/80">
                                    <div class="flex items-center border border-neutral-300 dark:border-neutral-700 rounded overflow-hidden">
                                        <button @click="updateQty(item.key, item.quantity - 1)" class="px-2.5 py-0.5 text-xs text-neutral-700 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-800">-</button>
                                        <span class="px-3 py-0.5 text-xs font-mono text-neutral-900 dark:text-white font-bold" x-text="item.quantity"></span>
                                        <button @click="updateQty(item.key, item.quantity + 1)" class="px-2.5 py-0.5 text-xs text-neutral-700 dark:text-neutral-400 hover:bg-neutral-200 dark:hover:bg-neutral-800">+</button>
                                    </div>
                                    <span class="font-mono text-xs font-bold text-neutral-900 dark:text-white" x-text="item.formatted_subtotal"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Drawer Footer & Checkout Action -->
                <div class="p-6 bg-[#FAF8F5] dark:bg-[#131313] border-t border-neutral-200 dark:border-neutral-800 space-y-4">
                    <div class="flex justify-between items-center text-sm font-mono tracking-wider">
                        <span class="text-neutral-600 dark:text-neutral-400 uppercase">Subtotal</span>
                        <span class="font-serif text-xl font-bold text-[#9E7D36] dark:text-[#D4AF37]" x-text="cartSubtotalFormatted">₦0</span>
                    </div>
                    <p class="text-[10px] text-neutral-500 font-mono tracking-wider">Taxes & Nigerian delivery calculated securely at checkout.</p>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('cart.index') }}" class="block text-center py-3 border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-300 hover:text-black dark:hover:text-white text-xs uppercase tracking-widest font-semibold hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                            View Bag
                        </a>
                        <a href="{{ route('checkout.index') }}" class="block text-center py-3 btn-gold text-xs font-bold tracking-widest">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Global Search Overlay -->
    <div x-show="searchOpen" x-cloak class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-start justify-center pt-24 px-4">
        <div @click.away="searchOpen = false" class="w-full max-w-2xl bg-[#FAF8F5] dark:bg-[#111] border border-[#C5A059]/40 p-6 rounded-2xl shadow-2xl space-y-4">
            <div class="flex justify-between items-center border-b border-neutral-200 dark:border-neutral-800 pb-3">
                <span class="font-serif tracking-[0.2em] text-sm text-[#9E7D36] dark:text-[#D4AF37] uppercase font-bold">Search The Fortunes Archive</span>
                <button @click="searchOpen = false" class="text-neutral-500 hover:text-black dark:text-neutral-400 dark:hover:text-white text-lg">&times;</button>
            </div>
            <form action="{{ route('shop.catalog') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Search denims, tees, outerwear, belts..."
                       class="w-full bg-white dark:bg-[#181818] border border-neutral-300 dark:border-neutral-700 focus:border-[#C5A059] px-4 py-3 text-sm text-neutral-900 dark:text-white placeholder-neutral-500 focus:outline-none rounded-xl">
                <button type="submit" class="absolute right-3 top-3 text-[#9E7D36] dark:text-[#D4AF37] hover:text-black dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
            <div class="flex flex-wrap gap-2 pt-2">
                <span class="text-[11px] text-neutral-500 font-mono tracking-wider">Popular:</span>
                <a href="{{ route('shop.catalog', ['search' => 'Denim']) }}" class="text-[11px] text-neutral-600 dark:text-neutral-300 hover:text-[#9E7D36] dark:hover:text-[#D4AF37] font-mono underline">Baggy Denim</a>
                <a href="{{ route('shop.catalog', ['search' => 'Tee']) }}" class="text-[11px] text-neutral-600 dark:text-neutral-300 hover:text-[#9E7D36] dark:hover:text-[#D4AF37] font-mono underline">Vintage Washed Shirt</a>
                <a href="{{ route('shop.catalog', ['search' => 'Belt']) }}" class="text-[11px] text-neutral-600 dark:text-neutral-300 hover:text-[#9E7D36] dark:hover:text-[#D4AF37] font-mono underline">Monogram Belt</a>
                <a href="{{ route('shop.catalog', ['search' => 'Racing']) }}" class="text-[11px] text-neutral-600 dark:text-neutral-300 hover:text-[#9E7D36] dark:hover:text-[#D4AF37] font-mono underline">Cyber Sahara</a>
            </div>
        </div>
    </div>

    <!-- Global Luxury Toast Notification -->
    <div x-show="showToast" x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="fixed bottom-6 left-6 z-50 flex items-center gap-3 bg-[#111] border border-[#D4AF37] px-5 py-3 rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.9)] pointer-events-none">
        <span class="w-2.5 h-2.5 rounded-full bg-[#D4AF37] animate-ping"></span>
        <span class="font-mono text-xs text-white uppercase tracking-wider font-semibold" x-text="toastMessage"></span>
    </div>



    <!-- 8. Haute Luxury Footer -->
    <footer class="bg-[#F0EDE6] dark:bg-[#050505] border-t border-[#D4AF37]/30 text-neutral-700 dark:text-neutral-400 mt-20 pt-16 pb-12 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            
            <!-- Col 1: Maison Fortunes -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 border border-[#9E7D36] dark:border-[#D4AF37] flex items-center justify-center bg-black">
                        <span class="font-serif text-sm font-bold text-[#D4AF37]">FC</span>
                    </div>
                    <span class="font-serif tracking-[0.25em] text-lg font-bold text-neutral-900 dark:text-white uppercase">FORTUNES</span>
                </div>
                <p class="text-xs leading-relaxed text-neutral-600 dark:text-neutral-400">
                    High-octane African haute streetwear. Crafted in Effurun with meticulous tailoring, vintage stone washes, and 18k antique gold hardware.
                </p>
                <div class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] space-y-1">
                    <p>ATELIER: PLOT 12, PTI ROAD</p>
                    <p>EFFURUN, DELTA STATE, NIGERIA</p>
                </div>
            </div>

            <!-- Col 2: Archive Collections -->
            <div>
                <h3 class="font-mono text-xs font-bold uppercase tracking-[0.25em] text-neutral-900 dark:text-white mb-4">Archive Collections</h3>
                <ul class="space-y-2.5 text-xs tracking-wider uppercase font-mono">
                    <li><a href="{{ route('shop.category', 'tops') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Tops & Heavy Tanks</a></li>
                    <li><a href="{{ route('shop.category', 'bottoms') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Baggy Denims & Cargos</a></li>
                    <li><a href="{{ route('shop.category', 'outerwear') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Racing Suits & Kimonos</a></li>
                    <li><a href="{{ route('shop.category', 'accessories') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Monogram Belts & Leather</a></li>
                    <li><a href="{{ route('shop.catalog', ['sort' => 'bestseller']) }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Best Sellers</a></li>
                </ul>
            </div>

            <!-- Col 3: Concierge & Client Care -->
            <div>
                <h3 class="font-mono text-xs font-bold uppercase tracking-[0.25em] text-neutral-900 dark:text-white mb-4">Concierge Services</h3>
                <ul class="space-y-2.5 text-xs tracking-wider uppercase font-mono">
                    <li><a href="{{ route('customer.dashboard') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Collector Account</a></li>
                    <li><a href="{{ route('wishlist.index') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Personal Wishlist</a></li>
                    <li><a href="{{ route('shop.maison') }}" class="hover:text-[#9E7D36] dark:hover:text-[#D4AF37] transition-colors">Effurun Flagship Hours</a></li>
                    <li><span class="text-neutral-500">Dedicated Courier Dispatch</span></li>
                    <li><a href="{{ route('admin.login') }}" class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-600 dark:hover:text-neutral-400 transition-colors">Staff Command Center</a></li>
                </ul>
            </div>

            <!-- Col 4: Newsletter & Direct Access -->
            <div class="space-y-4">
                <h3 class="font-mono text-xs font-bold uppercase tracking-[0.25em] text-neutral-900 dark:text-white">Private Archive Access</h3>
                <p class="text-xs text-neutral-600 dark:text-neutral-400">Receive private notices for numbered capsule drops and Effurun Atelier events.</p>
                <form onsubmit="event.preventDefault(); alert('You are now registered for the private Fortunes 2026 Archive drops.');" class="space-y-2">
                    <input type="email" placeholder="Your luxury email address..." required
                           class="w-full bg-white dark:bg-[#141414] border border-neutral-300 dark:border-neutral-700 px-3.5 py-2.5 text-xs text-neutral-900 dark:text-white placeholder-neutral-500 focus:outline-none focus:border-[#D4AF37] rounded">
                    <button type="submit" class="w-full py-2.5 btn-gold text-xs font-bold tracking-widest">
                        Join The Archive
                    </button>
                </form>
            </div>
        </div>

        <!-- Bottom Copyright & Payment Badges -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-neutral-300 dark:border-neutral-900 flex flex-col md:flex-row items-center justify-between gap-4 text-xs font-mono text-neutral-500">
            <p>© 2026 FORTUNES COLLECTION. ALL RIGHTS RESERVED. POWERED BY LARAVEL & PHP 8.3.</p>
            <div class="flex items-center gap-3 text-[11px] text-neutral-500 dark:text-neutral-400">
                <span class="px-2 py-0.5 border border-neutral-300 dark:border-neutral-800 rounded bg-white dark:bg-[#111]">PAYSTACK SECURE</span>
                <span class="px-2 py-0.5 border border-neutral-300 dark:border-neutral-800 rounded bg-white dark:bg-[#111]">FLUTTERWAVE</span>
                <span class="px-2 py-0.5 border border-neutral-300 dark:border-neutral-800 rounded bg-white dark:bg-[#111]">VISA / MASTERCARD</span>
                <span class="px-2 py-0.5 border border-neutral-300 dark:border-neutral-800 rounded bg-white dark:bg-[#111]">VERVE</span>
            </div>
        </div>
    </footer>

    <!-- Alpine.js & Livewire Scripts -->
    <script>
        function fortunesApp() {
            return {
                darkMode: localStorage.getItem('fc_theme') === 'light' ? false : true,
                navVisible: {{ request()->routeIs('shop.index') ? 'false' : 'true' }},
                mobileMenuOpen: false,
                cartDrawerOpen: false,
                searchOpen: false,
                ambientPlaying: false,
                audioCtx: null,
                audioNodes: [],
                toastMessage: '',
                showToast: false,
                cartCount: {{ session('fortunes_cart') ? count(session('fortunes_cart')) : 0 }},
                cartItems: [],
                cartSubtotal: 0,
                cartSubtotalFormatted: '₦0',
                freeShippingPercent: 0,
                freeShippingText: 'Complimentary at ₦500,000',

                init() {
                    // Sync initial theme
                    if (localStorage.getItem('fc_theme') === 'light') {
                        this.darkMode = false;
                        document.documentElement.classList.add('light');
                        document.documentElement.classList.remove('dark');
                    } else {
                        this.darkMode = true;
                        document.documentElement.classList.add('dark');
                        document.documentElement.classList.remove('light');
                    }

                    // On Home page, header/ticker appears when hero slides out or user scrolls past hero
                    @if(request()->routeIs('shop.index'))
                        window.addEventListener('scroll', () => {
                            if (window.scrollY > 50) {
                                this.navVisible = true;
                            } else if (window.scrollY < 20) {
                                this.navVisible = false;
                            }
                        }, { passive: true });

                        window.addEventListener('show-nav', () => {
                            this.navVisible = true;
                        });

                        window.addEventListener('hide-nav', () => {
                            this.navVisible = false;
                        });
                    @endif

                    this.fetchCartData();
                },

                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        document.documentElement.classList.remove('light');
                        localStorage.setItem('fc_theme', 'dark');
                        this.notify('Dark Couture Mode Active');
                    } else {
                        document.documentElement.classList.add('light');
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('fc_theme', 'light');
                        this.notify('Haute Light Mode Active');
                    }
                },

                notify(msg) {
                    this.toastMessage = msg;
                    this.showToast = true;
                    setTimeout(() => { this.showToast = false; }, 3200);
                },

                openCartDrawer() {
                    this.fetchCartData();
                    this.cartDrawerOpen = true;
                },

                quickAddToCart(productId, variantId = null) {
                    fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId, variant_id: variantId, quantity: 1 })
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.fetchCartData();
                        this.cartDrawerOpen = true;
                        this.notify(data.message || 'Added to your Archive Bag');
                    })
                    .catch(() => {
                        window.location.href = '{{ route('cart.index') }}';
                    });
                },

                toggleWishlist(productId) {
                    fetch('{{ route('wishlist.toggle') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(r => {
                        if (r.redirected) {
                            window.location.href = r.url;
                            return;
                        }
                        this.notify('Fortunes Wishlist Updated');
                    })
                    .catch(() => {
                        this.notify('Fortunes Wishlist Updated');
                    });
                },

                fetchCartData() {
                    fetch('{{ route('cart.data') }}')
                        .then(r => r.json())
                        .then(data => {
                            this.cartItems = Object.values(data.items || {});
                            this.cartCount = data.total_quantity || 0;
                            this.cartSubtotal = data.subtotal || 0;
                            this.cartSubtotalFormatted = data.formatted_subtotal || '₦0';
                            this.freeShippingPercent = data.free_shipping_progress || 0;
                            this.freeShippingText = data.free_shipping_qualified
                                ? 'Qualified for VIP Delivery'
                                : 'Add ' + data.formatted_amount_needed + ' for VIP Delivery';
                        })
                        .catch(() => {});
                },

                updateQty(itemKey, qty) {
                    fetch('{{ route('cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ item_key: itemKey, quantity: qty })
                    })
                    .then(r => r.json())
                    .then(() => this.fetchCartData());
                },

                removeFromCart(itemKey) {
                    fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ item_key: itemKey })
                    })
                    .then(r => r.json())
                    .then(() => {
                        this.fetchCartData();
                        this.notify('Silhouette removed from Bag');
                    });
                },

                toggleAmbientVibe() {
                    this.ambientPlaying = !this.ambientPlaying;
                    if (this.ambientPlaying) {
                        try {
                            const AudioCtx = window.AudioContext || window.webkitAudioContext;
                            this.audioCtx = new AudioCtx();
                            const masterGain = this.audioCtx.createGain();
                            masterGain.gain.setValueAtTime(0.001, this.audioCtx.currentTime);
                            masterGain.gain.exponentialRampToValueAtTime(0.04, this.audioCtx.currentTime + 1.2);

                            // Low-pass filter for smooth luxury boutique feel
                            const filter = this.audioCtx.createBiquadFilter();
                            filter.type = 'lowpass';
                            filter.frequency.setValueAtTime(480, this.audioCtx.currentTime);

                            // Warm luxury chord harmonics: Root 108Hz, Fifth 162Hz, Octave 216Hz, Nine 243Hz
                            const freqs = [108, 162, 216, 243];
                            this.audioNodes = [];
                            freqs.forEach(f => {
                                const osc = this.audioCtx.createOscillator();
                                osc.type = 'sine';
                                osc.frequency.setValueAtTime(f, this.audioCtx.currentTime);
                                osc.connect(filter);
                                osc.start();
                                this.audioNodes.push(osc);
                            });

                            filter.connect(masterGain);
                            masterGain.connect(this.audioCtx.destination);
                            this.audioNodes.push(masterGain);
                            this.notify('Fortunes Effurun Ambient Soundscape Active');
                        } catch(e) {}
                    } else {
                        if (this.audioCtx) {
                            try {
                                this.audioNodes.forEach(node => {
                                    if (node.stop) node.stop();
                                });
                                this.audioCtx.close();
                            } catch(e) {}
                            this.audioCtx = null;
                            this.audioNodes = [];
                            this.notify('Ambient Sound Muted');
                        }
                    }
                }
            };
        }
    </script>
    @stack('scripts')
    @livewireScripts
</body>
</html>
