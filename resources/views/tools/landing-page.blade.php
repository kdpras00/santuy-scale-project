@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Landing Page Generator</h1>
        <p class="text-gray-600">Buat landing page profesional dalam hitungan detik dengan bantuan AI.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Input Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold mb-4">Informasi Produk</h2>
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('landing-page-generator.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" id="product_name" name="product_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Contoh: Obat Pelangsing Herbal" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Jelaskan produk Anda secara singkat..." required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Target Audience</label>
                    <input type="text" id="target_audience" name="target_audience" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Contoh: Wanita usia 25-40 tahun" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keunggulan Utama</label>
                    <input type="text" id="key_benefits" name="key_benefits" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Contoh: 100% Alami, Tanpa Efek Samping" required>
                </div>
                
                <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2.5 font-medium hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                    </svg>
                    Generate & Simpan
                </button>
            </form>
        </div>

        <!-- Preview Area -->
        <div class="bg-gray-100 rounded-xl border border-gray-200 p-8 flex flex-col items-center justify-start text-center min-h-[400px] overflow-y-auto" id="preview-container">
            <div id="placeholder-preview" class="flex flex-col items-center justify-center h-full">
                <div class="bg-white p-4 rounded-full shadow-sm mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Preview Landing Page</h3>
                <p class="text-gray-500 max-w-xs">Isi formulir di sebelah kiri untuk melihat hasil landing page Anda di sini.</p>
            </div>
            
            <!-- Live Preview Content (Hidden by default) -->
            <div id="live-preview" class="w-full bg-white shadow-lg rounded-lg overflow-hidden hidden text-left">
                <!-- Hero Section -->
                <div class="bg-green-600 text-white p-8 text-center">
                    <h1 class="text-3xl font-bold mb-4" id="preview-title">Nama Produk</h1>
                    <p class="text-lg opacity-90 mb-6" id="preview-desc">Deskripsi produk akan muncul di sini...</p>
                    <button class="bg-white text-green-600 px-6 py-2 rounded-full font-bold hover:bg-gray-100 transition">Beli Sekarang</button>
                </div>
                
                <!-- Benefits Section -->
                <div class="p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 text-center">Kenapa Memilih Kami?</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <p id="preview-benefits">Keunggulan produk...</p>
                        </div>
                    </div>
                </div>
                
                <!-- Target Audience -->
                <div class="bg-gray-50 p-8 text-center">
                    <p class="text-gray-600">Cocok untuk: <span id="preview-audience" class="font-medium text-gray-900">Semua orang</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = ['product_name', 'description', 'target_audience', 'key_benefits'];
        const previewContainer = document.getElementById('preview-container');
        const placeholder = document.getElementById('placeholder-preview');
        const livePreview = document.getElementById('live-preview');
        
        const previewElements = {
            product_name: document.getElementById('preview-title'),
            description: document.getElementById('preview-desc'),
            target_audience: document.getElementById('preview-audience'),
            key_benefits: document.getElementById('preview-benefits')
        };

        function updatePreview() {
            let hasContent = false;
            
            inputs.forEach(id => {
                const input = document.getElementById(id);
                const value = input.value;
                if (value) {
                    hasContent = true;
                    if (previewElements[id]) {
                        previewElements[id].textContent = value;
                    }
                }
            });

            if (hasContent) {
                placeholder.classList.add('hidden');
                livePreview.classList.remove('hidden');
            } else {
                placeholder.classList.remove('hidden');
                livePreview.classList.add('hidden');
            }
        }

        inputs.forEach(id => {
            document.getElementById(id).addEventListener('input', updatePreview);
        });
    });
</script>
@endpush
@endsection
