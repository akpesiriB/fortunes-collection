@extends('layouts.admin')

@section('title', 'FULFILLMENT HUB | Fortunes Admin')
@section('page_title', 'Order Fulfillment Hub')

@section('content')
<div class="space-y-6">
    
    <!-- Status Filter Pills -->
    <div class="flex flex-wrap items-center gap-2 font-mono text-xs">
        <a href="{{ route('admin.orders.index') }}"
           class="px-4 py-2 rounded-lg uppercase tracking-wider {{ !request('status') ? 'bg-[#D4AF37] text-black font-bold' : 'bg-[#141414] text-neutral-300 hover:text-white border border-neutral-700' }}">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}"
           class="px-4 py-2 rounded-lg uppercase tracking-wider {{ request('status') === 'paid' ? 'bg-[#D4AF37] text-black font-bold' : 'bg-[#141414] text-neutral-300 hover:text-white border border-neutral-700' }}">
            Paid ({{ $statusCounts['paid'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
           class="px-4 py-2 rounded-lg uppercase tracking-wider {{ request('status') === 'processing' ? 'bg-[#D4AF37] text-black font-bold' : 'bg-[#141414] text-neutral-300 hover:text-white border border-neutral-700' }}">
            In Production ({{ $statusCounts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}"
           class="px-4 py-2 rounded-lg uppercase tracking-wider {{ request('status') === 'shipped' ? 'bg-[#D4AF37] text-black font-bold' : 'bg-[#141414] text-neutral-300 hover:text-white border border-neutral-700' }}">
            Dispatched ({{ $statusCounts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}"
           class="px-4 py-2 rounded-lg uppercase tracking-wider {{ request('status') === 'delivered' ? 'bg-[#D4AF37] text-black font-bold' : 'bg-[#141414] text-neutral-300 hover:text-white border border-neutral-700' }}">
            Delivered ({{ $statusCounts['delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
           class="px-4 py-2 rounded-lg uppercase tracking-wider {{ request('status') === 'pending' ? 'bg-[#D4AF37] text-black font-bold' : 'bg-[#141414] text-neutral-300 hover:text-white border border-neutral-700' }}">
            Pending ({{ $statusCounts['pending'] }})
        </a>
    </div>

    <!-- Search Form -->
    <form method="GET" class="flex items-center gap-3 font-mono text-xs">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order #, customer, phone..."
               class="bg-[#141414] border border-neutral-700 px-4 py-2.5 text-white rounded-lg focus:border-[#D4AF37] focus:outline-none w-72">
        <button type="submit" class="px-5 py-2.5 bg-neutral-800 hover:bg-[#D4AF37] text-neutral-200 hover:text-black uppercase font-bold rounded-lg">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.orders.index') }}" class="text-neutral-400 hover:text-white">Clear</a>
        @endif
    </form>

    <!-- Orders Table -->
    <div class="bg-[#121212] border border-neutral-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-neutral-800 text-neutral-400 uppercase text-[10px] tracking-widest bg-[#151515]">
                        <th class="py-3 px-4">Order #</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Destination</th>
                        <th class="py-3 px-4">Items</th>
                        <th class="py-3 px-4">Amount (₦)</th>
                        <th class="py-3 px-4">Payment</th>
                        <th class="py-3 px-4">Fulfillment Status</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($orders as $ord)
                        <tr class="hover:bg-neutral-800/30 transition-colors">
                            <td class="py-3 px-4 font-bold text-white">{{ $ord->order_number }}</td>
                            <td class="py-3 px-4">
                                <span class="text-white block font-bold">{{ $ord->customer_name }}</span>
                                <span class="text-neutral-500 text-[10px]">{{ $ord->customer_phone }}</span>
                            </td>
                            <td class="py-3 px-4 text-neutral-300">
                                {{ $ord->shippingAddress?->city ?? 'Effurun' }}, {{ $ord->shippingAddress?->state ?? 'Delta' }}
                            </td>
                            <td class="py-3 px-4 text-neutral-400">{{ $ord->items->count() }} item(s)</td>
                            <td class="py-3 px-4 text-[#D4AF37] font-bold">{{ $ord->formatted_total }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $ord->payment_status === 'paid' ? 'bg-emerald-950 text-emerald-400 border border-emerald-800' : 'bg-neutral-800 text-neutral-400' }}">
                                    {{ $ord->payment_status }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold border {{ $ord->status_badge_class }}">
                                    {{ $ord->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-neutral-400 text-[11px]">{{ $ord->created_at->format('M d, H:i') }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.orders.show', $ord) }}" class="text-[#D4AF37] hover:underline font-bold">Fulfill →</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-neutral-500">No orders match the selected criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-neutral-800">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
