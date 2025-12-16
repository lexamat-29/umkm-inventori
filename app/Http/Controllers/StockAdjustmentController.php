<?php

namespace App\Http\Controllers;

use App\Models\StockAdjustment;
use App\Models\Product;
use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        $adjustments = StockAdjustment::with(['product', 'user'])
            ->latest()
            ->paginate(20);
        
        return view('stock-adjustments.index', compact('adjustments'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        
        return view('stock-adjustments.create', compact('products'));
    }

    public function store(Request $request)
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
        
        return redirect()->route('stock-adjustments.index')
            ->with('success', 'Penyesuaian stok berhasil disimpan.');
    }

    public function show(StockAdjustment $stockAdjustment)
    {
        $stockAdjustment->load(['product', 'user']);
        
        return view('stock-adjustments.show', compact('stockAdjustment'));
    }
}
