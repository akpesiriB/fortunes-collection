@extends('layouts.admin')

@section('title', 'EDIT SILHOUETTE | Fortunes Admin')
@section('page_title', 'Edit ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between border-b border-neutral-800 pb-4">
        <a href="{{ route('admin.products.index') }}" class="font-mono text-xs text-neutral-400 hover:text-[#D4AF37]">← Back to Catalog</a>
        <span class="font-mono text-xs text-[#D4AF37] uppercase">Editing: {{ $product->sku }}</span>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="bg-[#121212] border border-neutral-800 rounded-2xl p-8 space-y-6 font-mono text-xs">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Product Title *</label>
                <input type="text" name="name" required value="{{ old('name', $product->name) }}"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded font-serif text-base focus:border-[#D4AF37] focus:outline-none uppercase">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">SKU Code *</label>
                <input type="text" name="sku" required value="{{ old('sku', $product->sku) }}"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded uppercase focus:border-[#D4AF37] focus:outline-none">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Subtitle / Line</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $product->subtitle) }}"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded uppercase focus:border-[#D4AF37] focus:outline-none">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Category *</label>
                <select name="category_id" required class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Hot Series / Fastest-Selling Brand</label>
                <select name="collection_id" class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
                    <option value="">None (Standard)</option>
                    @foreach($collections as $col)
                        <option value="{{ $col->id }}" {{ $product->collection_id == $col->id ? 'selected' : '' }}>{{ $col->name }} ({{ $col->season }})</option>
                    @endforeach
                </select>
                <p class="text-[11px] text-neutral-500 mt-1">Assign to a Hot Series (e.g. Gucci, Balenciaga, Casablanca) to feature in trending capsules.</p>
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Price in Nigerian Naira (₦) *</label>
                <input type="number" step="0.01" name="price" required value="{{ old('price', $product->price) }}"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
            </div>

            <div>
                <label class="block text-neutral-400 uppercase mb-1">Compare-At Price (₦)</label>
                <input type="number" step="0.01" name="compare_at_price" value="{{ old('compare_at_price', $product->compare_at_price) }}"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Featured Image URL *</label>
                <input type="url" name="featured_image" required value="{{ old('featured_image', $product->featured_image) }}"
                       class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Short Description</label>
                <textarea name="short_description" rows="2"
                          class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Full Description *</label>
                <textarea name="description" rows="4" required
                          class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-neutral-400 uppercase mb-1">Silhouette Details</label>
                <textarea name="details" rows="3"
                          class="w-full bg-[#181818] border border-neutral-700 p-3 text-white rounded focus:border-[#D4AF37]">{{ old('details', $product->details) }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-neutral-800 flex flex-wrap items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer text-white">
                <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="text-[#D4AF37]">
                <span>Featured on Homepage</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer text-white">
                <input type="checkbox" name="is_new" value="1" {{ $product->is_new ? 'checked' : '' }} class="text-[#D4AF37]">
                <span>New Arrival Flag</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer text-white">
                <input type="checkbox" name="is_bestseller" value="1" {{ $product->is_bestseller ? 'checked' : '' }} class="text-[#D4AF37]">
                <span>Best Seller Badge</span>
            </label>
            <div class="flex items-center gap-2">
                <span class="text-neutral-400">Status:</span>
                <select name="status" class="bg-[#181818] border border-neutral-700 p-1.5 rounded text-white">
                    <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex justify-end gap-4">
            <a href="{{ route('admin.products.index') }}" class="px-6 py-3 border border-neutral-700 rounded text-neutral-400 hover:text-white uppercase font-bold">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 btn-gold text-xs font-bold uppercase rounded shadow">
                Update Silhouette
            </button>
        </div>
    </form>
</div>
@endsection
