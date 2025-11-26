@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Stok</h1>
            <p class="text-gray-600">Kelola inventaris produk Anda dengan mudah.</p>
        </div>
        <button onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Produk
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex gap-4">
        <div class="flex-1 relative">
            <input type="text" placeholder="Cari nama produk, SKU..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 absolute left-3 top-2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
        <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-green-500 focus:border-green-500">
            <option>Semua Kategori</option>
            <option>Elektronik</option>
            <option>Fashion</option>
            <option>Aksesoris</option>
        </select>
        <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-green-500 focus:border-green-500">
            <option>Status Stok</option>
            <option>Tersedia</option>
            <option>Menipis</option>
            <option>Habis</option>
        </select>
    </div>

    <!-- Stock Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/50' }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                                <span class="font-medium text-gray-900">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->sku }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->category }}</td>
                        <td class="px-6 py-4 text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $product->stock }}</td>
                        <td class="px-6 py-4">
                            @if($product->stock > 10)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Tersedia</span>
                            @elseif($product->stock > 0)
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Menipis</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">Habis</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <button onclick="openEditModal({{ $product }})" class="text-blue-600 hover:underline">Edit</button>
                                <form action="{{ route('stock-management.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100 bg-gray-50 flex justify-between items-center">
            <span class="text-sm text-gray-500">Menampilkan 1-3 dari 45 produk</span>
            <div class="flex gap-2">
                <button class="px-3 py-1 border border-gray-300 rounded bg-white text-sm disabled:opacity-50" disabled>Previous</button>
                <button class="px-3 py-1 border border-gray-300 rounded bg-white text-sm hover:bg-gray-50">Next</button>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Tambah Produk Baru</h3>
            <button onclick="closeModal('addProductModal')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('stock-management.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <input type="number" name="price" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" name="stock" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option>Elektronik</option>
                        <option>Fashion</option>
                        <option>Makanan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" accept="image/*">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2.5 font-medium hover:bg-green-700 transition-colors">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Edit Produk</h3>
            <button onclick="closeModal('editProductModal')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" id="editName" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                    <input type="text" name="sku" id="editSku" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <input type="number" name="price" id="editPrice" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" name="stock" id="editStock" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" id="editCategory" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option>Elektronik</option>
                        <option>Fashion</option>
                        <option>Makanan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" accept="image/*">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2.5 font-medium hover:bg-blue-700 transition-colors">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('addProductModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openEditModal(product) {
        const modal = document.getElementById('editProductModal');
        const form = document.getElementById('editProductForm');
        
        // Populate form
        document.getElementById('editName').value = product.name;
        document.getElementById('editSku').value = product.sku;
        document.getElementById('editPrice').value = product.price;
        document.getElementById('editStock').value = product.stock;
        document.getElementById('editCategory').value = product.category;

        // Set action URL
        form.action = `/stock-management/${product.id}`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>
@endsection
