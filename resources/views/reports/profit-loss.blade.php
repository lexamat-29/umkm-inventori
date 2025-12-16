<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Laba Rugi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Date Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('reports.profit-loss') }}" class="flex gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date', $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : $startDate) }}" 
                                   class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date', $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : $endDate) }}" 
                                   class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Profit & Loss Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-6">Ringkasan Laba Rugi</h3>

                    <div class="space-y-4">
                        <!-- Revenue -->
                        <div class="flex justify-between items-center p-4 bg-green-50 rounded">
                            <span class="font-medium text-gray-700">Total Pendapatan (Penjualan)</span>
                            <span class="text-xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                        </div>

                        <!-- COGS -->
                        <div class="flex justify-between items-center p-4 bg-red-50 rounded">
                            <span class="font-medium text-gray-700">Harga Pokok Penjualan (HPP)</span>
                            <span class="text-xl font-bold text-red-600">Rp {{ number_format($totalCOGS, 0, ',', '.') }}</span>
                        </div>

                        <!-- Gross Profit -->
                        <div class="flex justify-between items-center p-4 bg-blue-50 rounded border-t-2 border-blue-200">
                            <span class="font-semibold text-gray-800">Laba Kotor</span>
                            <span class="text-xl font-bold text-blue-600">Rp {{ number_format($grossProfit, 0, ',', '.') }}</span>
                        </div>

                        <!-- Purchases -->
                        <div class="flex justify-between items-center p-4 bg-orange-50 rounded">
                            <span class="font-medium text-gray-700">Total Pembelian</span>
                            <span class="text-xl font-bold text-orange-600">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</span>
                        </div>

                        <!-- Net Profit -->
                        <div class="flex justify-between items-center p-4 {{ $netProfit >= 0 ? 'bg-green-100' : 'bg-red-100' }} rounded border-t-4 {{ $netProfit >= 0 ? 'border-green-500' : 'border-red-500' }}">
                            <span class="font-bold text-gray-900">Laba Bersih</span>
                            <span class="text-2xl font-bold {{ $netProfit >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                Rp {{ number_format($netProfit, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Profit Margin -->
                        @if($totalRevenue > 0)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded">
                                <span class="font-medium text-gray-700">Margin Keuntungan</span>
                                <span class="text-xl font-bold text-gray-800">{{ number_format(($grossProfit / $totalRevenue) * 100, 2) }}%</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('reports.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    Kembali ke Laporan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
