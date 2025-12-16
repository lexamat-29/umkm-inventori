<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Struk Penjualan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" id="receipt">
                <div class="p-8">
                    <div class="text-center mb-6">
                        <h1 class="text-2xl font-bold">UMKM TOKO</h1>
                        <p class="text-sm text-gray-600">Sistem Manajemen Inventori</p>
                        <p class="text-sm text-gray-600">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="border-t border-b border-gray-300 py-4 mb-4">
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <p class="text-gray-600">No. Transaksi:</p>
                                <p class="font-semibold">{{ $sale->sale_number }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Kasir:</p>
                                <p class="font-semibold">{{ $sale->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Tanggal:</p>
                                <p class="font-semibold">{{ $sale->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Pembayaran:</p>
                                <p class="font-semibold">{{ ucfirst($sale->payment_method) }}</p>
                            </div>
                        </div>
                    </div>

                    <table class="w-full mb-4">
                        <thead>
                            <tr class="border-b border-gray-300">
                                <th class="text-left py-2">Produk</th>
                                <th class="text-center py-2">Qty</th>
                                <th class="text-right py-2">Harga</th>
                                <th class="text-right py-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->items as $item)
                                <tr class="border-b border-gray-200">
                                    <td class="py-2">{{ $item->product->name }}</td>
                                    <td class="text-center py-2">{{ $item->quantity }}</td>
                                    <td class="text-right py-2">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="text-right py-2">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="border-t-2 border-gray-300 pt-4">
                        <div class="flex justify-between text-xl font-bold mb-2">
                            <span>TOTAL:</span>
                            <span>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($sale->notes)
                        <div class="mt-4 p-3 bg-gray-100 rounded">
                            <p class="text-sm text-gray-600">Catatan:</p>
                            <p class="text-sm">{{ $sale->notes }}</p>
                        </div>
                    @endif

                    <div class="text-center mt-6 text-sm text-gray-600">
                        <p>Terima kasih atas kunjungan Anda!</p>
                        <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-4 justify-center">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    🖨️ Cetak Struk
                </button>
                <a href="{{ route('pos.receipt.download', $sale->id) }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                    📄 Download PDF
                </a>
                <a href="{{ route('pos.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                    Transaksi Baru
                </a>
                <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                    Ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #receipt, #receipt * {
                visibility: visible;
            }
            #receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
</x-app-layout>
