@extends('layouts.app')

@section('content')
<div class="flex h-[calc(100vh-4rem)] gap-6">
    <!-- Product Grid -->
    <div class="flex-1 overflow-y-auto pr-2">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Aplikasi Kasir</h1>
                <p class="text-gray-600">Pilih produk untuk ditambahkan ke keranjang.</p>
            </div>
            <div class="relative">
                <input type="text" placeholder="Cari produk..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500 w-64">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 absolute left-3 top-2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($products as $product)
            <!-- Product Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div onclick="addToCart({{ $product }})" class="aspect-square bg-gray-100 relative cursor-pointer">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="Product" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                </div>
                <div class="p-3">
                    <h3 class="font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                    <p class="text-green-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-xs text-gray-500">Stok: <span id="stock-display-{{ $product->id }}">{{ $product->stock }}</span></p>
                        <div class="flex items-center gap-1">
                            <button onclick="updateQuantity({{ $product->id }}, -1)" class="w-6 h-6 rounded bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-gray-200">-</button>
                            <span id="qty-display-{{ $product->id }}" class="text-sm font-medium w-4 text-center">0</span>
                            <button onclick="addToCart({{ $product }})" class="w-6 h-6 rounded bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-200">+</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                Belum ada produk. Silakan tambahkan di Manajemen Stok.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div class="w-96 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full">
        <div class="p-4 border-b border-gray-100">
            <h2 class="font-bold text-lg text-gray-900">Keranjang Belanja</h2>
        </div>
        
        <div id="cartItems" class="flex-1 overflow-y-auto p-4 space-y-4">
            <!-- Cart items will be rendered here -->
            <div class="text-center text-gray-500 mt-10">Keranjang kosong</div>
        </div>

        <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl">
            <div class="flex justify-between items-center mb-2 text-sm">
                <span class="text-gray-600">Subtotal</span>
                <span id="cartSubtotal" class="font-medium">Rp 0</span>
            </div>
            <div class="flex justify-between items-center mb-4 text-sm">
                <span class="text-gray-600">Pajak (0%)</span>
                <span id="cartTax" class="font-medium">Rp 0</span>
            </div>
            <div class="flex justify-between items-center mb-6 text-lg font-bold">
                <span class="text-gray-900">Total</span>
                <span id="cartTotal" class="text-green-600">Rp 0</span>
            </div>
            <button onclick="checkout()" id="checkoutBtn" class="w-full bg-green-600 text-white rounded-lg py-3 font-bold hover:bg-green-700 transition-colors shadow-lg shadow-green-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                Bayar Sekarang
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cart = [];
    // Store initial stock to reset/calculate correctly
    const initialStock = {};

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize stock data
        @foreach($products as $product)
        initialStock[{{ $product->id }}] = {{ $product->stock }};
        @endforeach
    });

    function addToCart(product) {
        const currentStock = getCurrentStock(product.id);
        
        if (currentStock <= 0) {
            alert('Stok habis!');
            return;
        }

        const existingItem = cart.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                image: product.image,
                quantity: 1
            });
        }
        
        updateCartUI();
        updateStockDisplay(product.id);
    }

    function updateQuantity(productId, change) {
        const item = cart.find(item => item.id === productId);
        if (!item) return;

        const currentStock = getCurrentStock(productId);

        // Prevent adding more than stock
        if (change > 0 && currentStock <= 0) {
            alert('Stok tidak mencukupi!');
            return;
        }

        item.quantity += change;
        if (item.quantity <= 0) {
            cart = cart.filter(i => i.id !== productId);
        }
        
        updateCartUI();
        updateStockDisplay(productId);
    }

    function getCurrentStock(productId) {
        const item = cart.find(i => i.id === productId);
        const inCart = item ? item.quantity : 0;
        return initialStock[productId] - inCart;
    }

    function updateStockDisplay(productId) {
        const stockElement = document.getElementById(`stock-display-${productId}`);
        const qtyElement = document.getElementById(`qty-display-${productId}`);
        
        if (stockElement) {
            const currentStock = getCurrentStock(productId);
            stockElement.textContent = currentStock;
            
            // Visual feedback for low stock
            if (currentStock === 0) {
                stockElement.parentElement.classList.add('text-red-600', 'font-bold');
            } else {
                stockElement.parentElement.classList.remove('text-red-600', 'font-bold');
            }
        }

        if (qtyElement) {
            const item = cart.find(i => i.id === productId);
            qtyElement.textContent = item ? item.quantity : 0;
        }
    }

    function updateCartUI() {
        const container = document.getElementById('cartItems');
        const checkoutBtn = document.getElementById('checkoutBtn');
        
        if (cart.length === 0) {
            container.innerHTML = '<div class="text-center text-gray-500 mt-10">Keranjang kosong</div>';
            checkoutBtn.disabled = true;
            updateTotals();
            return;
        }

        checkoutBtn.disabled = false;
        container.innerHTML = cart.map(item => `
            <div class="flex gap-3">
                <img src="${item.image || 'https://via.placeholder.com/100'}" class="w-16 h-16 rounded-lg object-cover bg-gray-100">
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-900 line-clamp-1">${item.name}</h4>
                    <p class="text-xs text-gray-500 mb-1">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</p>
                    <div class="flex items-center gap-2">
                        <button onclick="updateQuantity(${item.id}, -1)" class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-gray-200">-</button>
                        <span class="text-sm font-medium w-4 text-center">${item.quantity}</span>
                        <button onclick="updateQuantity(${item.id}, 1)" class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-gray-200">+</button>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-900">${new Intl.NumberFormat('id-ID', { notation: "compact" }).format(item.price * item.quantity)}</p>
                </div>
            </div>
        `).join('');

        updateTotals();
    }

    function updateTotals() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = 0; // 0% tax for now
        const total = subtotal + tax;

        document.getElementById('cartSubtotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
        document.getElementById('cartTax').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(tax);
        document.getElementById('cartTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    }

    async function checkout() {
        if (cart.length === 0) return;

        if (!confirm('Proses pembayaran?')) return;

        const totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        try {
            const response = await fetch('{{ route("pos.checkout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: cart,
                    total_amount: totalAmount,
                    customer_name: 'Pelanggan Umum' // Can be added as input later
                })
            });

            const result = await response.json();

            if (result.success) {
                alert('Transaksi berhasil!');
                cart = [];
                updateCartUI();
                window.location.reload(); // Reload to update stock display
            } else {
                alert('Gagal: ' + result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan sistem');
        }
    }
</script>
@endpush
@endsection
