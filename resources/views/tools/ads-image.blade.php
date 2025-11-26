@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Ads Image Generator</h1>
        <p class="text-gray-600">Buat desain gambar iklan yang konversi tinggi secara otomatis.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Input Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold mb-4">Konten Iklan</h2>
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('ads-image-generator.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Headline (Judul Utama)</label>
                    <input type="text" id="headlineInput" name="headline" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="CUMA HARI INI!" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub-headline</label>
                    <input type="text" id="subheadlineInput" name="subheadline" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Diskon 50% Semua Item">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Call to Action (Tombol)</label>
                    <input type="text" id="ctaInput" name="cta" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="BELI SEKARANG" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <label class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 cursor-pointer block">
                        <input type="file" id="imageInput" name="image" class="hidden" accept="image/*">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-400 mx-auto mb-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="text-sm text-gray-500">Klik untuk upload gambar</span>
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warna Dominan</label>
                    <div class="flex gap-2" id="color-selector">
                        <div data-color="bg-red-600" class="w-8 h-8 rounded-full bg-red-600 cursor-pointer ring-2 ring-offset-2 ring-green-500 hover:ring-gray-300"></div>
                        <div data-color="bg-blue-600" class="w-8 h-8 rounded-full bg-blue-600 cursor-pointer ring-2 ring-offset-2 ring-transparent hover:ring-gray-300"></div>
                        <div data-color="bg-green-600" class="w-8 h-8 rounded-full bg-green-600 cursor-pointer ring-2 ring-offset-2 ring-transparent hover:ring-gray-300"></div>
                        <div data-color="bg-yellow-500" class="w-8 h-8 rounded-full bg-yellow-500 cursor-pointer ring-2 ring-offset-2 ring-transparent hover:ring-gray-300"></div>
                        <div data-color="bg-black" class="w-8 h-8 rounded-full bg-black cursor-pointer ring-2 ring-offset-2 ring-transparent hover:ring-gray-300"></div>
                    </div>
                    <input type="hidden" name="color" id="selectedColor" value="bg-red-600">
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
        <div class="bg-gray-100 rounded-xl border border-gray-200 p-8 flex flex-col items-center justify-center text-center min-h-[400px]">
             <!-- Mockup Result -->
             <!-- Mockup Result -->
             <div id="previewContainer" class="relative w-full aspect-square bg-red-600 rounded-lg overflow-hidden shadow-2xl flex flex-col items-center justify-center p-8 text-white transition-colors duration-300">
                <!-- Decorative Elements -->
                <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-black/10 rounded-full blur-2xl"></div>

                <div id="previewHeadline" class="relative z-10 text-4xl font-black uppercase mb-3 text-center tracking-tight drop-shadow-md">CUMA HARI INI!</div>
                
                <div class="relative z-10 mb-8">
                    <div id="previewSubheadline" class="text-xl font-bold text-center bg-black/20 backdrop-blur-sm px-6 py-2 rounded-lg shadow-sm border border-white/10">Diskon 50% Semua Item</div>
                </div>
                
                <div class="relative z-10 w-40 h-40 bg-white/20 backdrop-blur-md rounded-full mb-8 flex items-center justify-center overflow-hidden border-4 border-white/30 shadow-inner">
                    <img id="previewImage" src="" class="w-full h-full object-cover hidden">
                    <svg id="previewPlaceholder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>

                <div id="previewCta" class="relative z-10 bg-white text-red-600 px-8 py-3 rounded-full font-black text-xl shadow-lg hover:scale-105 transition-transform cursor-pointer uppercase tracking-wide">BELI SEKARANG</div>
             </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const headlineInput = document.getElementById('headlineInput');
        const subheadlineInput = document.getElementById('subheadlineInput');
        const ctaInput = document.getElementById('ctaInput');
        const imageInput = document.getElementById('imageInput');
        const colorSelector = document.getElementById('color-selector');
        const selectedColorInput = document.getElementById('selectedColor');

        const previewContainer = document.getElementById('previewContainer');
        const previewHeadline = document.getElementById('previewHeadline');
        const previewSubheadline = document.getElementById('previewSubheadline');
        const previewCta = document.getElementById('previewCta');
        const previewImage = document.getElementById('previewImage');
        const previewPlaceholder = document.getElementById('previewPlaceholder');

        // Text Updates
        headlineInput.addEventListener('input', (e) => previewHeadline.textContent = e.target.value || 'CUMA HARI INI!');
        subheadlineInput.addEventListener('input', (e) => previewSubheadline.textContent = e.target.value || 'Diskon 50% Semua Item');
        ctaInput.addEventListener('input', (e) => previewCta.textContent = e.target.value || 'BELI SEKARANG');

        // Image Upload
        imageInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    previewPlaceholder.classList.add('hidden');
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Color Selection
        colorSelector.addEventListener('click', function(e) {
            if (e.target.dataset.color) {
                const colorClass = e.target.dataset.color;
                
                // Update hidden input
                selectedColorInput.value = colorClass;

                // Update Preview Background
                // Remove all bg- colors first
                previewContainer.className = previewContainer.className.replace(/bg-\w+-\d+/g, '');
                previewContainer.classList.add(colorClass);

                // Update CTA Text Color to match background (simple logic)
                previewCta.className = previewCta.className.replace(/text-\w+-\d+/g, '');
                // Map bg color to text color
                const textColorMap = {
                    'bg-red-600': 'text-red-600',
                    'bg-blue-600': 'text-blue-600',
                    'bg-green-600': 'text-green-600',
                    'bg-yellow-500': 'text-yellow-600',
                    'bg-black': 'text-black'
                };
                previewCta.classList.add(textColorMap[colorClass] || 'text-gray-900');

                // Update Active State UI
                document.querySelectorAll('#color-selector div').forEach(div => {
                    div.classList.remove('ring-green-500');
                    div.classList.add('ring-transparent');
                });
                e.target.classList.remove('ring-transparent');
                e.target.classList.add('ring-green-500');
            }
        });
    });
</script>
@endpush
