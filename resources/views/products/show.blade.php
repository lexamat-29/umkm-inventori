<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Produk: {{ $product->name }}
            </h2>
            <a href="{{ route('products.edit', $product) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informasi Produk</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Nama Produk</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">SKU</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->sku }}</dd>
                                </div>
                                @if($product->description)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $product->description }}</dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if($product->is_active)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Tidak Aktif</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Harga & Stok</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Harga Beli</dt>
                                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Harga Jual</dt>
                                    <dd class="mt-1 text-sm font-semibold text-green-600">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Margin</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        Rp {{ number_format($product->harga_jual - $product->harga_beli, 0, ',', '.') }}
                                        ({{ number_format((($product->harga_jual - $product->harga_beli) / $product->harga_beli) * 100, 1) }}%)
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Stok Tersedia</dt>
                                    <dd class="mt-1">
                                        <span class="text-sm font-semibold {{ $product->isLowStock() ? 'text-orange-600' : 'text-gray-900' }}">
                                            {{ $product->stock_quantity }} unit
                                        </span>
                                        @if($product->isLowStock())
                                            <span class="ml-2 bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded">Stok Rendah</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Batas Minimum</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->minimum_stock_threshold }} unit</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
