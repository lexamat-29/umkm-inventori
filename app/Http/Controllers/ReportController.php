<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $sales = Sale::with('user', 'items.product')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->paginate(20);

        $totalSales = Sale::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount');
        $totalTransactions = Sale::whereBetween('created_at', [$startDate, $endDate])->count();

        // Daily sales for chart
        $dailySales = Sale::selectRaw('date(created_at) as date, SUM(total_amount) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('reports.sales', compact('sales', 'totalSales', 'totalTransactions', 'dailySales', 'startDate', 'endDate'));
    }

    public function profitLoss(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        // Total Revenue from Sales
        $totalRevenue = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        // Total Cost of Goods Sold
        $totalCOGS = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->sum(DB::raw('sale_items.quantity * products.harga_beli'));

        // Total Purchase Costs
        $totalPurchases = Purchase::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $grossProfit = $totalRevenue - $totalCOGS;
        $netProfit = $grossProfit; // Simplified - can add operating expenses later

        return view('reports.profit-loss', compact(
            'totalRevenue',
            'totalCOGS',
            'totalPurchases',
            'grossProfit',
            'netProfit',
            'startDate',
            'endDate'
        ));
    }

    public function topProducts(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $topProducts = DB::table('products')
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                DB::raw('SUM(sale_items.quantity) as total_quantity'),
                DB::raw('SUM(sale_items.total_price) as total_revenue'),
                DB::raw('COUNT(DISTINCT sales.id) as transaction_count')
            )
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('total_revenue')
            ->limit(20)
            ->get();

        return view('reports.top-products', compact('topProducts', 'startDate', 'endDate'));
    }

    public function exportSalesExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $sales = Sale::with('user', 'items.product')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        $filename = 'laporan-penjualan-' . date('Y-m-d') . '.xls';
        
        // Create Excel-compatible HTML table
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        table { border-collapse: collapse; width: 100%; }
        th { background-color: #4472C4; color: white; font-weight: bold; padding: 10px; border: 1px solid #000; }
        td { padding: 8px; border: 1px solid #ccc; }
        .number { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Metode Pembayaran</th>
                <th class="center">Jumlah Item</th>
                <th class="number">Total (Rp)</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($sales as $sale) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($sale->sale_number) . '</td>';
            $html .= '<td>' . $sale->created_at->format('d/m/Y H:i') . '</td>';
            $html .= '<td>' . htmlspecialchars($sale->user->name) . '</td>';
            $html .= '<td>' . ucfirst($sale->payment_method) . '</td>';
            $html .= '<td class="center">' . $sale->items->count() . '</td>';
            $html .= '<td class="number">' . number_format($sale->total_amount, 0, ',', '.') . '</td>';
            $html .= '<td>' . htmlspecialchars($sale->notes ?? '') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>
    </table>
</body>
</html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => strlen($html),
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}
