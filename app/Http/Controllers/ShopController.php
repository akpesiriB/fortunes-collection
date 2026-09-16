<?php

namespace App\Models; // for reference

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    /**
     * Homepage: Cinematic Haute Nigerian Streetwear Experience.
     */
    public function index(): View
    {
        $categories = Category::active()->get();
        $featuredCollections = Collection::featured()->withCount('products')->get();
        $featuredProducts = Product::active()
            ->with(['category', 'primaryImage', 'variants'])
            ->where('is_featured', true)
            ->take(8)
            ->get();

        $newArrivals = Product::active()
            ->with(['category', 'primaryImage', 'variants'])
            ->where('is_new', true)
            ->take(6)
            ->get();

        $testimonials = Testimonial::active()->take(4)->get();

        $ticker = SiteSetting::get('announcement_ticker', 'FORTUNES COLLECTION EFFURUN, ELEGANCE AS A WAY OF LIFE. STYLE AS AN EXPRESSION OF YOUR INNER SELF. WHERE FASHION MEETS PASSION. TIMELESS STYLE, ENDLESS POSSIBILITIES. CLOTHES THAT SPEAK WITHOUT SAYING A WORD. FASHION FOR EVERY STORY. ⬝ FLAGSHIP MAISON NOW OPEN AT PTI ROAD, EFFURUN ⬝ COMPLIMENTARY DELTA VIP DISPATCH ⬝ ARCHIVE 2026');
        $heroTitle = SiteSetting::get('hero_title', 'FORTUNES COLLECTION');
        $heroSubtitle = SiteSetting::get('hero_subtitle', 'PLAY YOUR FIT. BUILD YOUR LEGACY.');
        $maisonStatus = SiteSetting::get('maison_status', 'CURRENT STATUS: ARCHIVE 03 PRODUCTION');
        $maisonAddress = SiteSetting::get('maison_address', 'PLOT 12, PTI ROAD, EFFURUN, DELTA STATE');

        return view('shop.index', compact(
            'categories',
            'featuredCollections',
            'featuredProducts',
            'newArrivals',
            'testimonials',
            'ticker',
            'heroTitle',
            'heroSubtitle',
            'maisonStatus',
            'maisonAddress'
        ));
    }

    /**
     * Catalog / Shop view with filtering.
     */
    public function catalog(Request $request, ?string $category = null): View
    {
        $categories = Category::active()->get();
        $collections = Collection::active()->get();

        $query = Product::active()->with(['category', 'collection', 'primaryImage', 'variants']);

        if ($category) {
            $cat = Category::where('slug', $category)->firstOrFail();
            $query->where('category_id', $cat->id);
            $activeCategory = $cat;
        } else {
            $activeCategory = null;
            if ($request->filled('category')) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->query('category'));
                });
            }
        }

        $activeCollection = null;
        if ($request->filled('collection')) {
            $activeCollection = Collection::where('slug', $request->query('collection'))->first();
            if ($activeCollection) {
                $query->where('collection_id', $activeCollection->id);
            }
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->query('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'bestseller' => $query->orderBy('is_bestseller', 'desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        return view('shop.catalog', compact('products', 'categories', 'collections', 'activeCategory', 'activeCollection', 'sort'));
    }

    /**
     * Product detail view with gallery and variant selector.
     */
    public function show(string $slug): View
    {
        $product = Product::active()
            ->with(['category', 'collection', 'images', 'variants', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $product->increment('view_count');

        $relatedProducts = Product::active()
            ->with(['category', 'primaryImage'])
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    /**
     * Maison / About Fortunes page.
     */
    public function maison(): View
    {
        $maisonAddress = SiteSetting::get('maison_address', 'PLOT 12, PTI ROAD, EFFURUN, DELTA STATE');
        $maisonStatus = SiteSetting::get('maison_status', 'STATUS: ARCHIVE 03 CRAFTING');
        return view('shop.maison', compact('maisonAddress', 'maisonStatus'));
    }
}
