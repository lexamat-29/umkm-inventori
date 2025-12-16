<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Point of Sale (POS)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Product Selection (2/3 width) -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-4">
                            <input type="text" id="product-search" placeholder="Cari produk (nama atau SKU)..." 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" autofocus>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Pilih Produk</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="product-grid">
                                @foreach($products as $product)
                                    <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->harga_jual }}, {{ $product->stock_quantity }})" 
                                            class="product-item p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition text-left">
                                        <h4 class="font-semibold text-sm mb-1">{{ $product->name }}</h4>
                                        <p class="text-xs text-gray-500 mb-2">{{ $product->sku }}</p>
                                        <p class="text-sm font-bold text-green-600">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Stok: {{ $product->stock_quantity }}</p>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Cart & Checkout (1/3 width) -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Keranjang Belanja</h3>
                            
                            <div id="cart-items" class="space-y-2 mb-4 max-h-64 overflow-y-auto">
                                <p class="text-gray-500 text-center py-8">Keranjang kosong</p>
                            </div>

                            <div class="border-t pt-4 mb-4">
                                <div class="flex justify-between text-lg font-bold mb-4">
                                    <span>Total:</span>
                                    <span id="total-amount" class="text-green-600">Rp 0</span>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                                    <select id="payment-method" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="cash">Tunai</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea id="notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>

                                <button onclick="processCheckout()" id="checkout-btn" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded mb-2">
                                    Proses Pembayaran
                                </button>
                                <button onclick="clearCart()" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Reset Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let allProducts = @json($products);

        // Product search
        document.getElementById('product-search').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const productItems = document.querySelectorAll('.product-item');
            
            productItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        function addToCart(id, name, price, stock) {
            const existing = cart.find(item => item.product_id === id);
            
            if (existing) {
                if (existing.quantity >= stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                existing.quantity++;
            } else {
                cart.push({
                    product_id: id,
                    name: name,
                    unit_price: price,
                    quantity: 1,
                    stock: stock
                });
            }
            
            renderCart();
        }

        function updateQuantity(index, delta) {
            const item = cart[index];
            const newQty = item.quantity + delta;
            
            if (newQty <= 0) {
                cart.splice(index, 1);
            } else if (newQty > item.stock) {
                alert('Stok tidak mencukupi!');
                return;
            } else {
                item.quantity = newQty;
            }
            
            renderCart();
        }

        function removeItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        function renderCart() {
            const cartItems = document.getElementById('cart-items');
            const totalAmount = document.getElementById('total-amount');
            
            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-500 text-center py-8">Keranjang kosong</p>';
                totalAmount.textContent = 'Rp 0';
                return;
            }
            
            let total = 0;
            let html = '';
            
            cart.forEach((item, index) => {
                const subtotal = item.unit_price * item.quantity;
                total += subtotal;
                
                html += `
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div class="flex-1">
                            <p class="font-medium text-sm">${item.name}</p>
                            <p class="text-xs text-gray-500">Rp ${formatNumber(item.unit_price)} x ${item.quantity}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="updateQuantity(${index}, -1)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded text-xs">-</button>
                            <span class="text-sm font-medium">${item.quantity}</span>
                            <button onclick="updateQuantity(${index}, 1)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded text-xs">+</button>
                            <button onclick="removeItem(${index})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-xs ml-2">×</button>
                        </div>
                    </div>
                `;
            });
            
            cartItems.innerHTML = html;
            totalAmount.textContent = 'Rp ' + formatNumber(total);
        }

        async function processCheckout() {
            if (cart.length === 0) {
                alert('Keranjang kosong!');
                return;
            }
            
            const items = cart.map(item => ({
                product_id: item.product_id,
                quantity: item.quantity,
                unit_price: item.unit_price
            }));
            
            const data = {
                items: items,
                payment_method: document.getElementById('payment-method').value,
                notes: document.getElementById('notes').value
            };
            
            try {
                const response = await fetch('{{ route("pos.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert(`Penjualan berhasil!\nNo. Transaksi: ${result.sale_number}`);
                    window.location.href = '{{ route("pos.receipt", ":id") }}'.replace(':id', result.sale_id);
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        }

        function clearCart() {
            if (cart.length > 0 && !confirm('Yakin ingin mengosongkan keranjang?')) {
                return;
            }
            cart = [];
            renderCart();
        }

        function formatNumber(num) {
            return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
</x-app-layout>
