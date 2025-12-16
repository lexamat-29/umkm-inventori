<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Pembelian Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('purchases.store') }}" id="purchase-form">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Supplier Name -->
                            <div>
                                <label for="supplier_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Supplier *</label>
                                <input type="text" name="supplier_name" id="supplier_name" value="{{ old('supplier_name') }}" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('supplier_name') border-red-500 @enderror">
                                @error('supplier_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pembelian *</label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('purchase_date') border-red-500 @enderror">
                                @error('purchase_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <textarea name="notes" id="notes" rows="2"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Items -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Item Pembelian</h3>
                                <button type="button" onclick="addItem()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                    + Tambah Item
                                </button>
                            </div>

                            <div id="items-container" class="space-y-4">
                                <!-- Items will be added here -->
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between text-xl font-bold">
                                <span>Total Pembelian:</span>
                                <span id="grand-total" class="text-green-600">Rp 0</span>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Simpan Pembelian
                            </button>
                            <a href="{{ route('purchases.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 0;
        const products = @json($products);

        function addItem() {
            const container = document.getElementById('items-container');
            const div = document.createElement('div');
            div.className = 'grid grid-cols-12 gap-2 p-4 bg-gray-50 rounded';
            div.innerHTML = `
                <div class="col-span-5">
                    <select name="items[${itemIndex}][product_id]" required onchange="updatePrice(${itemIndex})" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Produk</option>
                        ${products.map(p => `<option value="${p.id}" data-price="${p.harga_beli}">${p.name} (${p.sku})</option>`).join('')}
                    </select>
                </div>
                <div class="col-span-2">
                    <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" required min="1" value="1"
                           onchange="calculateTotal()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="col-span-2">
                    <input type="number" name="items[${itemIndex}][unit_cost]" placeholder="Harga" required min="0" step="0.01"
                           onchange="calculateTotal()" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="col-span-2">
                    <input type="text" readonly placeholder="Subtotal" class="item-subtotal w-full rounded-md border-gray-300 bg-gray-100">
                </div>
                <div class="col-span-1">
                    <button type="button" onclick="this.parentElement.parentElement.remove(); calculateTotal();" 
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded">×</button>
                </div>
            `;
            container.appendChild(div);
            itemIndex++;
        }

        function updatePrice(index) {
            const select = document.querySelector(`select[name="items[${index}][product_id]"]`);
            const priceInput = document.querySelector(`input[name="items[${index}][unit_cost]"]`);
            const option = select.options[select.selectedIndex];
            if (option.dataset.price) {
                priceInput.value = option.dataset.price;
                calculateTotal();
            }
        }

        function calculateTotal() {
            let grandTotal = 0;
            document.querySelectorAll('#items-container > div').forEach(item => {
                const qty = parseFloat(item.querySelector('input[name*="[quantity]"]').value) || 0;
                const price = parseFloat(item.querySelector('input[name*="[unit_cost]"]').value) || 0;
                const subtotal = qty * price;
                item.querySelector('.item-subtotal').value = 'Rp ' + formatNumber(subtotal);
                grandTotal += subtotal;
            });
            document.getElementById('grand-total').textContent = 'Rp ' + formatNumber(grandTotal);
        }

        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Add first item on load
        addItem();
    </script>
</x-app-layout>
