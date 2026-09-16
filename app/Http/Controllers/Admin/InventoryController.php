<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Inventory::with(['product.primaryImage', 'variant']);

        if ($request->filled('filter')) {
            if ($request->query('filter') === 'low_stock') {
                $query->whereRaw('stock_count <= low_stock_threshold');
            } elseif ($request->query('filter') === 'out_of_stock') {
                $query->where('stock_count', '<=', 0);
            }
        }

        $inventories = $query->latest()->paginate(20)->withQueryString();
        $totalItems = Inventory::sum('stock_count');
        $lowStockCount = Inventory::whereRaw('stock_count <= low_stock_threshold')->count();
        $outOfStockCount = Inventory::where('stock_count', '<=', 0)->count();

        return view('admin.inventory.index', compact('inventories', 'totalItems', 'lowStockCount', 'outOfStockCount'));
    }

    public function update(Request $request, Inventory $inventory): RedirectResponse
    {
        $validated = $request->validate([
            'stock_count' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ]);

        $inventory->update($validated);

        if ($inventory->product_variant_id) {
            ProductVariant::where('id', $inventory->product_variant_id)
                ->update([
                    'stock_quantity' => $validated['stock_count'],
                    'is_available' => $validated['stock_count'] > 0,
                ]);
        }

        return back()->with('success', 'Inventory level updated.');
    }
}
