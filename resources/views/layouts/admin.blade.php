<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COMMAND CENTER | Fortunes Collection Admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts & Tailwind CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', '"Playfair Display"', 'Georgia', 'serif'],
                        display: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"Space Grotesk"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/fortunes.css') }}">
    @livewireStyles
</head>
<body class="bg-[#080808] text-neutral-200 font-sans antialiased min-h-screen flex">

    <!-- 1. Admin Sidebar -->
    <aside class="w-64 bg-[#0E0E0E] border-r border-[#D4AF37]/20 flex flex-col justify-between shrink-0 hidden md:flex">
        <div>
            <!-- Brand -->
            <div class="h-20 flex items-center gap-3 px-6 border-b border-neutral-800">
                <div class="w-8 h-8 border border-[#D4AF37] flex items-center justify-center bg-black">
                    <span class="font-serif text-sm font-bold text-[#D4AF37]">FC</span>
                </div>
                <div>
                    <span class="font-serif tracking-[0.2em] text-sm font-bold uppercase text-white block">FORTUNES</span>
                    <span class="font-mono text-[9px] tracking-[0.3em] text-[#D4AF37] uppercase">COMMAND CENTER</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-xs font-mono tracking-wider uppercase">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#D4AF37] text-black font-bold shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Overview</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.products.*') ? 'bg-[#D4AF37] text-black font-bold shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Archive Catalog</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-[#D4AF37] text-black font-bold shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span>Fulfillment</span>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] rounded-full bg-[#1A1A1A] text-[#D4AF37] border border-[#D4AF37]/30">Orders</span>
                </a>

                <a href="{{ route('admin.inventory.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.inventory.*') ? 'bg-[#D4AF37] text-black font-bold shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>Inventory Matrix</span>
                </a>

                <a href="{{ route('admin.coupons.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.coupons.*') ? 'bg-[#D4AF37] text-black font-bold shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span>Promotions</span>
                </a>

                <a href="{{ route('admin.content.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.content.*') ? 'bg-[#D4AF37] text-black font-bold shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-neutral-800' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Maison CMS</span>
                </a>

                <a href="{{ route('admin.database') }}" target="_blank"
                   class="flex items-center justify-between px-4 py-3 rounded-lg transition-all text-neutral-400 hover:text-white hover:bg-neutral-800">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                        <span>Database & SQL</span>
                    </div>
                    <span class="px-2 py-0.5 text-[9px] rounded-full bg-[#1A1A1A] text-[#D4AF37] border border-[#D4AF37]/30">PMA ↗</span>
                </a>
            </nav>
        </div>

        <!-- Footer Info & Public Store link -->
        <div class="p-4 border-t border-neutral-800 space-y-3">
            <a href="{{ route('shop.index') }}" target="_blank"
               class="flex items-center justify-between text-xs font-mono tracking-wider text-[#D4AF37] hover:underline px-2">
                <span>View Storefront</span>
                <span>↗</span>
            </a>
            <div class="px-2 pt-2 text-[10px] font-mono text-neutral-500">
                <span>LARAVEL 11 ⬝ PHP 8.3</span>
            </div>
        </div>
    </aside>

    <!-- 2. Main Administration Area -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Navbar -->
        <header class="h-20 bg-[#0C0C0C] border-b border-neutral-800 px-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest">Atelier Effurun</span>
                <span class="text-neutral-600">/</span>
                <h1 class="font-serif text-lg font-bold text-white tracking-wide">@yield('page_title', 'Control Center')</h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 pl-4 border-l border-neutral-800">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-semibold text-white font-mono uppercase">{{ auth('admin')->user()->name ?? 'Administrator' }}</p>
                        <span class="text-[9px] font-mono text-[#D4AF37] uppercase tracking-widest">Director Privileges</span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 border border-red-900/50 hover:bg-red-950/40 text-red-400 rounded text-xs font-mono tracking-wider transition-colors">
                            Exit
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Flash alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-950/60 border-b border-emerald-800/60 text-emerald-300 text-xs font-mono tracking-wider flex justify-between items-center">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-400">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-950/60 border-b border-red-800/60 text-red-300 text-xs font-mono tracking-wider flex justify-between items-center">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-400">&times;</button>
            </div>
        @endif

        <!-- Main View Content -->
        <main class="p-6 md:p-8 flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>
