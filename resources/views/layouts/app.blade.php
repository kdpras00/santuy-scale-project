<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Santuy Scale') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" 
      x-data="{ 
          sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
          init() {
              this.$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))
          }
      }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-white border-r border-gray-200 fixed h-full overflow-y-auto z-10 hidden md:block transition-all duration-300"
               :class="sidebarOpen ? 'w-64' : 'w-20'"
               x-cloak>
            <div class="p-4 flex items-center justify-between sticky top-0 bg-white z-10">
                <div x-show="sidebarOpen" x-cloak class="flex items-center gap-2 font-bold text-xl overflow-hidden whitespace-nowrap transition-opacity duration-300">
                    <div class="w-6 h-6 bg-black rounded-full flex-shrink-0 flex items-center justify-center text-white text-xs">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span>Santuy Scale</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>

            <nav class="px-2 py-4 space-y-1">
                <!-- <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2 mt-2 transition-opacity duration-300">Mulai Di Sini</div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Panduan & Tutorial</span>
                </a> -->

                <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2 mt-6 transition-opacity duration-300">Tools Generator</div>

                <a href="{{ route('landing-page-generator') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('landing-page-generator') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('landing-page-generator') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Landing Page Generator</span>
                </a>

                <a href="{{ route('video-prompter') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('video-prompter') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('video-prompter') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Video Prompter</span>
                </a>

                <a href="{{ route('wa-testimonial-generator') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('wa-testimonial-generator') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('wa-testimonial-generator') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">WA Testimonial Generator</span>
                </a>

                <a href="{{ route('affiliate-script-generator') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('affiliate-script-generator') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('affiliate-script-generator') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Affiliate Script Generator</span>
                </a>

                <a href="{{ route('ads-image-generator') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('ads-image-generator') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('ads-image-generator') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Ads Image Generator</span>
                </a>

                <div x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2 mt-6 transition-opacity duration-300">Manajemen Bisnis</div>

                <a href="{{ route('pos') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('pos') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('pos') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Aplikasi Kasir (POS)</span>
                </a>

                <a href="{{ route('sales-recap') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('sales-recap') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('sales-recap') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Rekap Penjualan</span>
                </a>

                <a href="{{ route('stock-management') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('stock-management') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('stock-management') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Manajemen Stok</span>
                </a>

                <a href="{{ route('cashflow') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('cashflow') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('cashflow') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Cashflow Bisnis</span>
                </a>

                <a href="{{ route('location-profit') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('location-profit') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('location-profit') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Peta Cuan Lokasi</span>
                </a>

                <a href="{{ route('hpp-calculator') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('hpp-calculator') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('hpp-calculator') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Kalkulator HPP Otomatis</span>
                </a>

                <a href="{{ route('team-management') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-md group {{ request()->routeIs('team-management') ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('team-management') ? 'text-green-700' : 'text-gray-400 group-hover:text-gray-500' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    <span x-show="sidebarOpen" class="whitespace-nowrap transition-opacity duration-300">Manajemen Tim</span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-4 border-t border-gray-200 bg-white"
                 x-data="{
                     user: JSON.parse(localStorage.getItem('currentUser')) || { name: 'Pengguna', email: 'belum@login.com', photoURL: 'https://ui-avatars.com/api/?name=P&background=random' },
                     logout() {
                         localStorage.removeItem('currentUser');
                         localStorage.removeItem('sidebarOpen'); // Optional: reset sidebar state
                         window.location.href = '{{ route('login') }}';
                     }
                 }">
                <div class="flex items-center gap-3">
                    <img :src="user.photoURL" alt="User Avatar" class="w-8 h-8 rounded-full flex-shrink-0">
                    <div x-show="sidebarOpen" class="flex-1 min-w-0 transition-opacity duration-300">
                        <p class="text-sm font-medium text-gray-900 truncate" x-text="user.name">Nama Pengguna</p>
                        <p class="text-xs text-gray-500 truncate" x-text="user.email">email@contoh.com</p>
                    </div>
                    <a href="{{ route('settings') }}" x-show="sidebarOpen" class="text-gray-400 hover:text-gray-600 transition-opacity duration-300" title="Pengaturan">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <button @click="logout" x-show="sidebarOpen" class="text-gray-400 hover:text-red-600 transition-opacity duration-300" title="Keluar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 transition-all duration-300"
              :class="sidebarOpen ? 'md:ml-64' : 'md:ml-20'"
              x-cloak>
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
