<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Struk Penjualan
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Receipt Card -->
            <div class="bg-white shadow-lg overflow-hidden border border-gray-200" id="receipt">
                <div class="p-6 sm:p-8" style="font-family: 'Courier New', Courier, monospace;">
                    <div class="text-center mb-6 border-b border-dashed border-gray-400 pb-4">
                        <h1 class="text-xl font-bold uppercase tracking-tight">UMKM TOKO</h1>
                        <p class="text-xs text-gray-600 mt-1 font-sans font-semibold">Sistem Manajemen Inventori</p>
                        <p class="text-[10px] text-gray-500 font-sans italic">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="border-b border-dashed border-gray-400 pb-4 mb-4">
                        <div class="grid grid-cols-2 gap-y-1 text-[11px] leading-tight">
                            <span class="text-gray-500">No:</span>
                            <span class="font-bold text-right">{{ $sale->sale_number }}</span>
                            
                            <span class="text-gray-500">Kasir:</span>
                            <span class="font-bold text-right">{{ $sale->user->name }}</span>
                            
                            <span class="text-gray-500">Tgl:</span>
                            <span class="font-bold text-right">{{ $sale->created_at->format('d/m/y H:i') }}</span>
                            
                            <span class="text-gray-500">Byr:</span>
                            <span class="font-bold text-right uppercase">{{ $sale->payment_method }}</span>
                        </div>
                    </div>

                    <table class="w-full mb-4 text-[11px]">
                        <thead>
                            <tr class="border-b border-dashed border-gray-400">
                                <th class="text-left py-2">Item</th>
                                <th class="text-center py-2">Qty</th>
                                <th class="text-right py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dashed divide-gray-200 font-bold">
                            @foreach($sale->items as $item)
                                <tr>
                                    <td class="py-2 pr-2">
                                        <div class="leading-tight">{{ $item->product->name }}</div>
                                        <div class="text-[9px] text-gray-500 font-sans italic leading-none mt-0.5">@Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="text-center py-2">{{ $item->quantity }}</td>
                                    <td class="text-right py-2 whitespace-nowrap">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="border-t-2 border-double border-gray-400 pt-4 mb-6">
                        <div class="flex justify-between items-center text-lg font-black">
                            <span>TOTAL:</span>
                            <span class="text-blue-600">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($sale->notes)
                        <div class="mb-6 p-2 bg-gray-50 border border-dashed border-gray-300 rounded text-[10px]">
                            <p class="text-gray-400 uppercase font-sans font-bold mb-1">Catatan:</p>
                            <p class="font-sans italic">{{ $sale->notes }}</p>
                        </div>
                    @endif

                    <div class="text-center text-[10px] text-gray-500 border-t border-dashed border-gray-400 pt-6 space-y-1">
                        <p class="font-black text-gray-800">TERIMA KASIH</p>
                        <p>Atas Kunjungan Anda</p>
                        <p class="font-sans italic">Barang tidak dapat dikembalikan</p>
                        <p class="pt-2 font-sans">{{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons - Stacked on mobile -->
            <div class="mt-8 flex flex-col gap-3">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="window.print()" class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak Struk
                    </button>
                    <a href="{{ route('pos.receipt.download', $sale->id) }}" class="flex-1 flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Download PDF
                    </a>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('pos.index') }}" class="flex-1 flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition active:scale-95">
                        Transaksi Baru
                    </a>
                    <a href="{{ route('dashboard') }}" class="flex-1 flex items-center justify-center gap-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition active:scale-95">
                        Ke Dashboard
                    </a>
                </div>
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
