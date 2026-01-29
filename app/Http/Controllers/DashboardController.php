<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Key Metrics
        $totalProducts = Product::count();
        $lowStockProducts = Product::lowStock()->count();
        $todaysSales = Sale::whereDate('created_at', today())->sum('total_amount');
        $monthlyRevenue = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        // Total Inventory Value
        $inventoryValue = Product::selectRaw('SUM(stock_quantity * harga_beli) as total')
            ->value('total') ?? 0;
        
        // Monthly Sales Chart (last 6 months)
        $monthlySales = Sale::selectRaw("strftime('%Y-%m', created_at) as month, SUM(total_amount) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Top Selling Products (by revenue)
        $topProducts = DB::table('products')
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->select('products.id', 'products.name', 'products.sku', DB::raw('SUM(sale_items.total_price) as revenue'))
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();
        
        // Low Stock Alerts
        $lowStockAlerts = Product::lowStock()
            ->where('is_active', true)
            ->orderBy('stock_quantity')
            ->limit(10)
            ->get();
        
        // Recent Sales
        $recentSales = Sale::with('user')
            ->latest()
            ->limit(10)
            ->get();
        
        return view('dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'todaysSales',
            'monthlyRevenue',
            'inventoryValue',
            'monthlySales',
            'topProducts',
            'lowStockAlerts',
            'recentSales'
        ));
    }
}
