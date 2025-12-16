<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('user')
            ->latest()
            ->paginate(15);
        
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        
        return view('purchases.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Calculate total
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['unit_cost'];
            }
            
            // Create purchase
            $purchase = Purchase::create([
                'purchase_number' => Purchase::generatePurchaseNumber(),
                'user_id' => auth()->id(),
                'supplier_name' => $validated['supplier_name'],
                'total_amount' => $totalAmount,
                'purchase_date' => $validated['purchase_date'],
                'notes' => $validated['notes'] ?? null,
            ]);
            
            // Create purchase items and update stock
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Create purchase item
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'total_cost' => $item['quantity'] * $item['unit_cost'],
                ]);
                
                // Increase stock
                $product->increment('stock_quantity', $item['quantity']);
                
                // Update purchase price
                $product->update(['harga_beli' => $item['unit_cost']]);
            }
            
            DB::commit();
            
            return redirect()->route('purchases.index')
                ->with('success', 'Pembelian berhasil disimpan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['items.product', 'user']);
        
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $purchase->load('items');
        $products = Product::active()->orderBy('name')->get();
        
        return view('purchases.edit', compact('purchase', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        
        $purchase->update($validated);
        
        return redirect()->route('purchases.index')
            ->with('success', 'Pembelian berhasil diperbarui.');
    }

    public function destroy(Purchase $purchase)
    {
        // Note: Deleting a purchase will cascade delete items
        // but won't automatically adjust stock back
        $purchase->delete();
        
        return redirect()->route('purchases.index')
            ->with('success', 'Pembelian berhasil dihapus.');
    }
}
