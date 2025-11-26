@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Peta Cuan Lokasi</h1>
        <p class="text-gray-600">Analisis potensi keuntungan berdasarkan lokasi bisnis Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Map Area -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-[500px] relative">
            <div id="map" class="w-full h-full z-0"></div>
            
            <!-- Floating Search -->
            <div class="absolute top-4 left-4 right-4 bg-white rounded-lg shadow-lg p-2 flex gap-2 z-[1000]">
                <input type="text" placeholder="Cari lokasi..." class="flex-1 border-none focus:ring-0 text-sm">
                <button class="bg-green-600 text-white px-4 py-1.5 rounded-md text-sm font-medium">Cari</button>
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4">Analisis Lokasi</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kepadatan Penduduk</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <p class="text-right text-xs font-bold mt-1">Tinggi (85%)</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Kompetitor</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                        <p class="text-right text-xs font-bold mt-1">Sedang (45%)</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Daya Beli</p>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 70%"></div>
                        </div>
                        <p class="text-right text-xs font-bold mt-1">Menengah Atas (70%)</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-4">Rekomendasi Bisnis</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Cocok untuk <strong>Coffee Shop</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Potensi omzet <strong>Rp 5-8jt / hari</strong></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-yellow-500 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <span>Perlu parkir luas</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Map
        var map = L.map('map').setView([-6.2088, 106.8456], 13); // Jakarta Coordinates

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Add a marker
        L.marker([-6.2088, 106.8456]).addTo(map)
            .bindPopup('Lokasi Anda')
            .openPopup();
    });
</script>
@endsection
