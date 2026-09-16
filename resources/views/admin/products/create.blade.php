@extends('layouts.admin')

@section('title', 'ADD SILHOUETTE | Fortunes Admin')
@section('page_title', 'Create New Silhouette')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between border-b border-neutral-800 pb-4">
        <a href="{{ route('admin.products.index') }}" class="font-mono text-xs text-neutral-400 hover:text-[#D4AF37]">← Back to Catalog</a>
        <span class="font-mono text-xs text-[#D4AF37] uppercase">Archive Registration</span>
    </div>

    @if($errors->any())
        <div class="p-4 bg-red-950/60 border border-red-800 text-red-300 text-xs font-mono rounded-lg">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" class="bg-[#121212] border border-neutral-800 rounded-2xl p-8 space-y-6 font-mono text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Product Title *</label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. FORTUNES HEAVY BAGGY CARPENTER DENIM"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded font-serif text-base focus:border-[#D4AF37] focus:outline-none uppercase">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">SKU Code *</label>
                <input type="text" name="sku" required value="{{ old('sku') }}" placeholder="FC-DEN-009"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded uppercase focus:border-[#D4AF37] focus:outline-none">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Subtitle / Line</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="BOTTOMS / ARCHIVE"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded uppercase focus:border-[#D4AF37] focus:outline-none">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Category *</label>
                <select name="category_id" required class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Hot Series / Fastest-Selling Brand</label>
                <select name="collection_id" class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
                    <option value="">None (Standard Release)</option>
                    @foreach($collections as $col)
                        <option value="{{ $col->id }}">{{ $col->name }} ({{ $col->season }})</option>
                    @endforeach
                </select>
                <p class="text-[11px] text-neutral-500 mt-1">Assign to a Hot Series (e.g. Gucci, Balenciaga, Casablanca) to feature in trending capsules.</p>
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Price in Nigerian Naira (₦) *</label>
                <input type="number" step="0.01" name="price" required value="{{ old('price') }}" placeholder="299500"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Compare-At Price (₦) (Optional)</label>
                <input type="number" step="0.01" name="compare_at_price" value="{{ old('compare_at_price') }}" placeholder="340000"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Featured Image URL *</label>
                <input type="url" name="featured_image" required value="{{ old('featured_image') }}" placeholder="https://images.unsplash.com/photo-..."
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Short Description</label>
                <textarea name="short_description" rows="2" placeholder="16oz heavyweight Japanese selvedge denim with vintage mineral stone wash..."
                          class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">{{ old('short_description') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Full Description *</label>
                <textarea name="description" rows="4" required placeholder="Full atelier notes and construction breakdown..."
                          class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">{{ old('description') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Silhouette Details (Bullet Points)</label>
                <textarea name="details" rows="3" placeholder="• 100% Heavyweight Cotton&#10;• Custom Fortunes gold hardware..."
                          class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">{{ old('details') }}</textarea>
            </div>
        </div>

        <!-- Flags -->
        <div class="pt-4 border-t border-neutral-800 flex flex-wrap items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer text-white">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="text-[#D4AF37]">
                <span>Featured on Homepage</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer text-white">
                <input type="checkbox" name="is_new" value="1" checked class="text-[#D4AF37]">
                <span>New Arrival Flag</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer text-white">
                <input type="checkbox" name="is_bestseller" value="1" class="text-[#D4AF37]">
                <span>Best Seller Badge</span>
            </label>
            <div class="flex items-center gap-2">
                <span class="text-neutral-400">Status:</span>
                <select name="status" class="bg-[#181818] border border-neutral-700 p-1.5 rounded text-white">
                    <option value="active">Active</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>

        <!-- Initial Variants -->
        <div class="pt-6 border-t border-neutral-800 space-y-3">
            <h3 class="font-serif text-base font-bold uppercase text-white">INITIAL SIZE VARIANTS & STOCK</h3>
            <div class="grid grid-cols-4 gap-3">
                <div class="p-3 bg-[#181818] border border-neutral-700 rounded space-y-2">
                    <input type="text" name="variants[0][size]" value="S" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                    <input type="number" name="variants[0][stock]" value="10" placeholder="Stock" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                </div>
                <div class="p-3 bg-[#181818] border border-neutral-700 rounded space-y-2">
                    <input type="text" name="variants[1][size]" value="M" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                    <input type="number" name="variants[1][stock]" value="15" placeholder="Stock" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                </div>
                <div class="p-3 bg-[#181818] border border-neutral-700 rounded space-y-2">
                    <input type="text" name="variants[2][size]" value="L" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                    <input type="number" name="variants[2][stock]" value="10" placeholder="Stock" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                </div>
                <div class="p-3 bg-[#181818] border border-neutral-700 rounded space-y-2">
                    <input type="text" name="variants[3][size]" value="XL" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                    <input type="number" name="variants[3][stock]" value="5" placeholder="Stock" class="w-full bg-black p-1.5 text-center text-white border border-neutral-800 rounded">
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-neutral-700 rounded text-neutral-400 hover:text-white uppercase font-bold">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 btn-gold text-xs font-bold uppercase rounded shadow">
                Save Silhouette
            </button>
        </div>
    </form>
</div>
@endsection
