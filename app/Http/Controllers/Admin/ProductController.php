<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'collection', 'variants', 'primaryImage']);

        if ($request->filled('search')) {
            $s = $request->query('search');
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('sku', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->query('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $collections = Collection::all();
        return view('admin.products.create', compact('categories', 'collections'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku',
            'subtitle' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'details' => 'nullable|string',
            'care_instructions' => 'nullable|string',
            'size_guide' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'is_featured' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_bestseller' => 'nullable|boolean',
            'status' => 'required|in:active,draft,archived',
            'featured_image' => 'required|string',
            'variants' => 'nullable|array',
        ]);

        $slug = Str::slug($validated['name']);
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::lower(Str::random(4));
        }

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => strtoupper($validated['sku']),
            'subtitle' => $validated['subtitle'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'],
            'details' => $validated['details'] ?? null,
            'care_instructions' => $validated['care_instructions'] ?? null,
            'size_guide' => $validated['size_guide'] ?? null,
            'price' => $validated['price'],
            'compare_at_price' => $validated['compare_at_price'] ?? null,
            'category_id' => $validated['category_id'],
            'collection_id' => $validated['collection_id'] ?? null,
            'is_featured' => !empty($validated['is_featured']),
            'is_new' => !empty($validated['is_new']),
            'is_bestseller' => !empty($validated['is_bestseller']),
            'status' => $validated['status'],
            'featured_image' => $validated['featured_image'],
        ]);

        // Primary Image
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $validated['featured_image'],
            'is_primary' => true,
            'alt_text' => $product->name,
            'sort_order' => 1,
        ]);

        // Add variants if specified
        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $v) {
                if (!empty($v['size'])) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $v['size'],
                        'color' => $v['color'] ?? 'Standard',
                        'color_hex' => $v['color_hex'] ?? '#0A0A0A',
                        'sku' => $product->sku . '-' . strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $v['size']), 0, 3)),
                        'price_override' => !empty($v['price_override']) ? $v['price_override'] : null,
                        'stock_quantity' => (int) ($v['stock'] ?? 0),
                        'is_available' => ((int) ($v['stock'] ?? 0)) > 0,
                    ]);

                    Inventory::create([
                        'product_id' => $product->id,
                        'product_variant_id' => $variant->id,
                        'stock_count' => (int) ($v['stock'] ?? 0),
                        'low_stock_threshold' => 5,
                        'reserved_count' => 0,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created in the archive.');
    }

    public function edit(Product $product): View
    {
        $product->load(['category', 'collection', 'variants', 'images']);
        $categories = Category::all();
        $collections = Collection::all();

        return view('admin.products.edit', compact('product', 'categories', 'collections'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'subtitle' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'description' => 'required|string',
            'details' => 'nullable|string',
            'care_instructions' => 'nullable|string',
            'size_guide' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'collection_id' => 'nullable|exists:collections,id',
            'is_featured' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_bestseller' => 'nullable|boolean',
            'status' => 'required|in:active,draft,archived',
            'featured_image' => 'required|string',
        ]);

        $product->update([
            'name' => $validated['name'],
            'sku' => strtoupper($validated['sku']),
            'subtitle' => $validated['subtitle'] ?? null,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'],
            'details' => $validated['details'] ?? null,
            'care_instructions' => $validated['care_instructions'] ?? null,
            'size_guide' => $validated['size_guide'] ?? null,
            'price' => $validated['price'],
            'compare_at_price' => $validated['compare_at_price'] ?? null,
            'category_id' => $validated['category_id'],
            'collection_id' => $validated['collection_id'] ?? null,
            'is_featured' => !empty($validated['is_featured']),
            'is_new' => !empty($validated['is_new']),
            'is_bestseller' => !empty($validated['is_bestseller']),
            'status' => $validated['status'],
            'featured_image' => $validated['featured_image'],
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product removed from active catalog.');
    }
}
