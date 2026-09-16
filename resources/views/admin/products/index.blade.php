@extends('layouts.admin')

@section('title', 'CATALOG ARCHIVE | Fortunes Admin')
@section('page_title', 'Archive Catalog Matrix')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <form method="GET" class="flex flex-wrap items-center gap-3 font-mono text-xs">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or SKU..."
                   class="bg-[#141414] border border-neutral-700 px-3 py-2 text-white rounded focus:border-[#D4AF37] focus:outline-none">
            <select name="category" onchange="this.form.submit()" class="bg-[#141414] border border-neutral-700 px-3 py-2 text-neutral-200 rounded">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-neutral-800 hover:bg-[#D4AF37] text-neutral-200 hover:text-black uppercase font-bold rounded">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 btn-gold text-xs font-bold uppercase tracking-wider rounded shadow flex items-center gap-2">
            <span>+</span>
            <span>Add New Silhouette</span>
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-[#121212] border border-neutral-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono text-xs">
                <thead>
                    <tr class="border-b border-neutral-800 text-neutral-400 uppercase text-[10px] tracking-widest bg-[#151515]">
                        <th class="py-3 px-4">Silhouette</th>
                        <th class="py-3 px-4">SKU</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Price (₦)</th>
                        <th class="py-3 px-4">Archive Stock</th>
                        <th class="py-3 px-4">Flags</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @foreach($products as $prod)
                        <tr class="hover:bg-neutral-800/30 transition-colors">
                            <td class="py-3 px-4 flex items-center gap-3">
                                <img src="{{ $prod->featured_image }}" alt="{{ $prod->name }}" class="w-10 h-12 object-cover rounded bg-neutral-900 border border-neutral-700">
                                <div>
                                    <span class="font-serif text-sm font-bold text-white uppercase block">{{ $prod->name }}</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-neutral-500 text-[10px]">{{ $prod->variants->count() }} Variants</span>
                                        @if($prod->collection)
                                            <span class="text-red-400 text-[10px] font-mono">🔥 {{ $prod->collection->name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-neutral-300 font-bold">{{ $prod->sku }}</td>
                            <td class="py-3 px-4 text-neutral-400">{{ $prod->category->name }}</td>
                            <td class="py-3 px-4 text-[#D4AF37] font-bold">{{ $prod->formatted_price }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $prod->total_stock <= 5 ? 'bg-amber-950 text-amber-300 border border-amber-800' : 'text-neutral-300' }}">
                                    {{ $prod->total_stock }} Units
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex gap-1 text-[9px]">
                                    @if($prod->is_featured) <span class="px-1.5 py-0.5 bg-yellow-950 text-yellow-400 border border-yellow-800 rounded">FEAT</span> @endif
                                    @if($prod->is_new) <span class="px-1.5 py-0.5 bg-blue-950 text-blue-400 border border-blue-800 rounded">NEW</span> @endif
                                    @if($prod->is_bestseller) <span class="px-1.5 py-0.5 bg-emerald-950 text-emerald-400 border border-emerald-800 rounded">BEST</span> @endif
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold {{ $prod->status === 'active' ? 'bg-emerald-950 text-emerald-400' : 'bg-neutral-800 text-neutral-400' }}">
                                    {{ $prod->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.products.edit', $prod) }}" class="text-[#D4AF37] hover:underline">Edit</a>
                                <form action="{{ route('admin.products.destroy', $prod) }}" method="POST" class="inline" onsubmit="return confirm('Archive this silhouette?');">
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

        <div class="p-4 border-t border-neutral-800">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
