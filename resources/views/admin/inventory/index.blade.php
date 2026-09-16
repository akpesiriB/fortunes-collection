@extends('layouts.admin')

@section('title', 'INVENTORY MATRIX | Fortunes Admin')
@section('page_title', 'Atelier Stock Matrix')

@section('content')
<div class="space-y-6">
    
    <!-- Top Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="p-6 bg-[#121212] border border-neutral-800 rounded-2xl space-y-1">
            <span class="font-mono text-[10px] text-neutral-400 uppercase tracking-widest">Total Inventory Pieces</span>
            <p class="font-serif text-3xl font-bold text-white">{{ $totalItems }} Units</p>
        </div>
        <div class="p-6 bg-[#121212] border border-amber-800/50 rounded-2xl space-y-1">
            <span class="font-mono text-[10px] text-amber-400 uppercase tracking-widest">Low Stock Items (&lt; 5 left)</span>
            <p class="font-serif text-3xl font-bold text-amber-300">{{ $lowStockCount }} Pieces</p>
        </div>
        <div class="p-6 bg-[#121212] border border-red-800/50 rounded-2xl space-y-1">
            <span class="font-mono text-[10px] text-red-400 uppercase tracking-widest">Sold Out Silhouettes</span>
            <p class="font-serif text-3xl font-bold text-red-400">{{ $outOfStockCount }} Silhouettes</p>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-[#121212] border border-neutral-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-neutral-800 text-neutral-400 uppercase text-[10px] tracking-widest bg-[#151515]">
                        <th class="py-3 px-4">Silhouette</th>
                        <th class="py-3 px-4">Variant Spec</th>
                        <th class="py-3 px-4">SKU Code</th>
                        <th class="py-3 px-4">Current Stock</th>
                        <th class="py-3 px-4">Threshold</th>
                        <th class="py-3 px-4 text-right">Instant Adjustment</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @foreach($inventories as $inv)
                        <tr class="hover:bg-neutral-800/30 transition-colors">
                            <td class="py-3 px-4 flex items-center gap-3">
                                <img src="{{ $inv->product->featured_image }}" alt="" class="w-10 h-12 object-cover rounded bg-neutral-900 border border-neutral-700">
                                <div>
                                    <span class="font-serif text-sm font-bold text-white uppercase">{{ $inv->product->name }}</span>
                                    <span class="text-neutral-500 text-[10px] block">{{ $inv->product->category->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-neutral-300">
                                {{ $inv->variant?->size ?? 'Standard' }} / {{ $inv->variant?->color ?? 'Standard' }}
                            </td>
                            <td class="py-3 px-4 text-neutral-400">{{ $inv->variant?->sku ?? $inv->product->sku }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded text-xs font-bold {{ $inv->stock_count <= 0 ? 'bg-red-950 text-red-400 border border-red-800' : ($inv->stock_count <= $inv->low_stock_threshold ? 'bg-amber-950 text-amber-300 border border-amber-800' : 'bg-emerald-950 text-emerald-400 border border-emerald-800') }}">
                                    {{ $inv->stock_count }} in Archive
                                </span>
                            </td>
                            <td class="py-3 px-4 text-neutral-400">&lt; {{ $inv->low_stock_threshold }}</td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.inventory.update', $inv) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    <input type="number" name="stock_count" value="{{ $inv->stock_count }}" min="0"
                                           class="w-16 bg-[#181818] border border-neutral-700 text-center py-1 text-white rounded">
                                    <input type="hidden" name="low_stock_threshold" value="{{ $inv->low_stock_threshold }}">
                                    <button type="submit" class="px-3 py-1 bg-neutral-800 hover:bg-[#D4AF37] text-neutral-300 hover:text-black rounded uppercase font-bold text-[10px] transition-colors">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-neutral-800">
            {{ $inventories->links() }}
        </div>
    </div>
</div>
@endsection
