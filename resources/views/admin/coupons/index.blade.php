@extends('layouts.admin')

@section('title', 'PROMOTIONS | Fortunes Admin')
@section('page_title', 'Promotional Coupons')

@section('content')
<div class="space-y-8 font-mono text-xs">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Active Coupons Table (8 Cols) -->
        <div class="lg:col-span-8 bg-[#121212] border border-neutral-800 rounded-2xl p-6 space-y-4 shadow-xl">
            <h3 class="font-serif text-lg font-bold uppercase text-white tracking-wider border-b border-neutral-800 pb-3">
                ACTIVE PROMOTIONS
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left font-mono text-xs">
                    <thead>
                        <tr class="border-b border-neutral-800 text-neutral-400 uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-2">Code</th>
                            <th class="py-3 px-2">Type</th>
                            <th class="py-3 px-2">Discount</th>
                            <th class="py-3 px-2">Min Spend (₦)</th>
                            <th class="py-3 px-2">Usages</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800">
                        @foreach($coupons as $c)
                            <tr class="hover:bg-neutral-800/30">
                                <td class="py-3 px-2 font-bold text-[#D4AF37]">{{ $c->code }}</td>
                                <td class="py-3 px-2 text-neutral-400 uppercase">{{ $c->type }}</td>
                                <td class="py-3 px-2 text-white font-bold">
                                    {{ $c->type === 'percentage' ? (int)$c->value . '%' : '₦' . number_format($c->value, 0) }}
                                </td>
                                <td class="py-3 px-2 text-neutral-300">₦{{ number_format($c->min_spend, 0) }}</td>
                                <td class="py-3 px-2 text-neutral-400">{{ $c->used_count }} / {{ $c->usage_limit ?? '∞' }}</td>
                                <td class="py-3 px-2">
                                    <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $c->is_active ? 'bg-emerald-950 text-emerald-400' : 'bg-neutral-800 text-neutral-400' }}">
                                        {{ $c->is_active ? 'Active' : 'Disabled' }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-right">
                                    <form action="{{ route('admin.coupons.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Delete promotion?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Coupon Form (4 Cols) -->
        <div class="lg:col-span-4 bg-[#141414] border border-neutral-800 rounded-2xl p-6 space-y-4 shadow-xl">
            <h3 class="font-serif text-lg font-bold uppercase text-white tracking-wider border-b border-neutral-800 pb-3">
                GENERATE PROMO CODE
            </h3>

            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4 font-mono text-xs">
                @csrf
                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Code *</label>
                    <input type="text" name="code" required placeholder="e.g. VIP2026"
                           class="w-full bg-[#181818] border border-neutral-700 p-2.5 text-white uppercase rounded focus:border-[#D4AF37]">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-neutral-400 uppercase mb-1">Type *</label>
                        <select name="type" class="w-full bg-[#181818] border border-neutral-700 p-2.5 text-white rounded">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Naira (₦)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-neutral-400 uppercase mb-1">Value *</label>
                        <input type="number" step="0.01" name="value" required placeholder="10 or 25000"
                               class="w-full bg-[#181818] border border-neutral-700 p-2.5 text-white rounded">
                    </div>
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Minimum Order Amount (₦)</label>
                    <input type="number" step="0.01" name="min_spend" value="100000"
                           class="w-full bg-[#181818] border border-neutral-700 p-2.5 text-white rounded">
                </div>

                <div>
                    <label class="block text-neutral-400 uppercase mb-1">Maximum Uses</label>
                    <input type="number" name="usage_limit" placeholder="100 (Leave empty for infinite)"
                           class="w-full bg-[#181818] border border-neutral-700 p-2.5 text-white rounded">
                </div>

                <label class="flex items-center gap-2 cursor-pointer text-white pt-1">
                    <input type="checkbox" name="is_active" value="1" checked class="text-[#D4AF37]">
                    <span>Activate Immediately</span>
                </label>

                <button type="submit" class="w-full py-3.5 btn-gold text-xs font-bold uppercase rounded shadow">
                    Create Promotion
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
