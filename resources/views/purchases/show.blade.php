<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pembelian: {{ $purchase->purchase_number }}
            </h2>
            <a href="{{ route('purchases.edit', $purchase) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informasi Pembelian</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">No. Pembelian</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $purchase->purchase_number }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Pembelian</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $purchase->purchase_date->format('d/m/Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Supplier</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $purchase->supplier_name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat Oleh</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $purchase->user->name }}</dd>
                                </div>
                                @if($purchase->notes)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $purchase->notes }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Ringkasan</h3>
                            <div class="bg-gray-50 p-4 rounded">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600">Jumlah Item:</span>
                                    <span class="text-sm font-medium">{{ $purchase->items->count() }} item</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-gray-600">Total Quantity:</span>
                                    <span class="text-sm font-medium">{{ $purchase->items->sum('quantity') }} unit</span>
                                </div>
                                <div class="flex justify-between pt-2 border-t">
                                    <span class="font-semibold">Total Pembelian:</span>
                                    <span class="font-semibold text-green-600">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-4">Item Pembelian</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($purchase->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->product->sku }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-900">
                                            Rp {{ number_format($item->unit_cost, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                            Rp {{ number_format($item->total_cost, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('purchases.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
