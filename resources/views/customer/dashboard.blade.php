@extends('layouts.app')

@section('title', 'COLLECTOR DASHBOARD | Fortunes Collection')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- User Profile Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-[#9E7D36]/30 dark:border-[#D4AF37]/30 pb-6 gap-4">
        <div>
            <span class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] uppercase tracking-[0.25em] font-bold">MEMBER SINCE {{ $user->created_at->format('Y') }}</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold uppercase text-neutral-900 dark:text-white tracking-tight mt-1">
                WELCOME, {{ $user->name }}
            </h1>
            <p class="text-xs text-neutral-600 dark:text-neutral-400 font-mono mt-0.5">{{ $user->email }}</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('customer.addresses') }}" class="px-4 py-2 border border-neutral-300 dark:border-neutral-700 hover:border-[#9E7D36] dark:hover:border-[#D4AF37] text-xs font-mono uppercase tracking-wider text-neutral-700 dark:text-neutral-300 hover:text-black dark:hover:text-white rounded transition-colors">
                Saved Addresses ({{ $addressesCount }})
            </a>
            <form action="{{ route('customer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 border border-red-300 dark:border-red-900/50 hover:bg-red-50 dark:hover:bg-red-950 text-red-600 dark:text-red-400 text-xs font-mono uppercase tracking-wider rounded transition-colors">
                    Sign Out
                </button>
            </form>
        </div>
    </div>

    <!-- Metric KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="p-6 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-2 shadow-sm">
            <span class="font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-widest block font-bold">Total Archive Spend</span>
            <span class="font-serif text-3xl font-bold text-[#9E7D36] dark:text-[#D4AF37]">₦{{ number_format($totalSpent, 0) }}</span>
            <p class="font-mono text-[10px] text-neutral-500">Verified via Paystack</p>
        </div>

        <div class="p-6 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-2 shadow-sm">
            <span class="font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-widest block font-bold">Total Orders</span>
            <span class="font-serif text-3xl font-bold text-neutral-900 dark:text-white">{{ $orders->count() }}</span>
            <a href="{{ route('customer.orders') }}" class="font-mono text-[10px] text-[#9E7D36] dark:text-[#D4AF37] hover:underline block uppercase font-bold">View Complete History →</a>
        </div>

        <div class="p-6 bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-2 shadow-sm">
            <span class="font-mono text-[10px] text-neutral-500 dark:text-neutral-400 uppercase tracking-widest block font-bold">Tier Status</span>
            <span class="font-serif text-3xl font-bold text-neutral-900 dark:text-white">VIP COLLECTOR</span>
            <p class="font-mono text-[10px] text-emerald-600 dark:text-emerald-400 font-medium">Complimentary Effurun Dispatch Active</p>
        </div>
    </div>

    <!-- Recent Orders Feed -->
    <div class="space-y-4">
        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
            <h2 class="font-serif text-xl font-bold uppercase text-neutral-900 dark:text-white tracking-wider">RECENT ACQUISITIONS</h2>
            <a href="{{ route('customer.orders') }}" class="font-mono text-xs text-[#9E7D36] dark:text-[#D4AF37] hover:underline uppercase tracking-wider font-bold">All Orders →</a>
        </div>

        @if($orders->isEmpty())
            <div class="p-12 text-center bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl space-y-3 shadow-sm">
                <p class="font-serif text-xl text-neutral-900 dark:text-white">No pieces in your collection yet.</p>
                <a href="{{ route('shop.catalog') }}" class="inline-block mt-2 px-6 py-2.5 btn-gold text-xs font-bold tracking-widest">
                    EXPLORE 2026 ARCHIVE
                </a>
            </div>
        @else
            <div class="bg-white dark:bg-[#121212] border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden divide-y divide-neutral-200 dark:divide-neutral-800 shadow-sm">
                @foreach($orders as $order)
                    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 font-mono text-xs">
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-neutral-900 dark:text-white text-sm">{{ $order->order_number }}</span>
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase border {{ $order->status_badge_class }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <span class="text-neutral-600 dark:text-neutral-400 text-[11px] block">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
                            <span class="text-neutral-500 text-[11px]">{{ $order->items->count() }} item(s)</span>
                        </div>

                        <div class="flex items-center justify-between md:justify-end gap-6">
                            <span class="font-serif text-lg font-bold text-[#9E7D36] dark:text-[#D4AF37]">{{ $order->formatted_total }}</span>
                            <a href="{{ route('customer.orders.show', $order->order_number) }}"
                               class="px-4 py-2 border border-neutral-300 dark:border-neutral-700 hover:border-[#9E7D36] dark:hover:border-[#D4AF37] text-neutral-800 dark:text-white hover:text-[#9E7D36] dark:hover:text-[#D4AF37] rounded uppercase tracking-wider transition-colors">
                                View Details →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
