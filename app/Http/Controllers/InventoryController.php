<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with('stockAdjustments')
            ->withCount('stockAdjustments')
            ->latest()
            ->paginate(15);
        
        $totalProducts = Product::count();
        $lowStockCount = Product::lowStock()->count();
        $outOfStockCount = Product::where('stock_quantity', '<=', 0)->count();
        $inventoryValue = Product::selectRaw('SUM(stock_quantity * harga_beli) as total')
            ->value('total') ?? 0;
        
        return view('inventory.index', compact(
            'products',
            'totalProducts',
            'lowStockCount',
            'outOfStockCount',
            'inventoryValue'
        ));
    }

    public function adjustments()
    {
        $adjustments = StockAdjustment::with(['product', 'user'])
            ->latest()
            ->paginate(20);
        
        return view('inventory.adjustments', compact('adjustments'));
    }

    public function createAdjustment()
    {
        $products = Product::active()->orderBy('name')->get();
        
        return view('inventory.create-adjustment', compact('products'));
    }

    public function storeAdjustment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:increase,decrease',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
        
        $product = Product::findOrFail($validated['product_id']);
        
        // Check if decrease would result in negative stock
        if ($validated['type'] === 'decrease' && $product->stock_quantity < $validated['quantity']) {
            return back()->withErrors([
                'quantity' => 'Jumlah pengurangan melebihi stok yang tersedia.'
            ])->withInput();
        }
        
        // Create adjustment record
        StockAdjustment::create([
            'product_id' => $validated['product_id'],
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'notes' => $validated['notes'] ?? null,
        ]);
        
        // Update product stock
        if ($validated['type'] === 'increase') {
            $product->increment('stock_quantity', $validated['quantity']);
        } else {
            $product->decrement('stock_quantity', $validated['quantity']);
        }
        
        return redirect()->route('inventory.index')
            ->with('success', 'Penyesuaian stok berhasil disimpan.');
    }
}
