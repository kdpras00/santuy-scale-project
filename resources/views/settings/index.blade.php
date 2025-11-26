@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto" 
     x-data="{
         user: JSON.parse(localStorage.getItem('currentUser')) || { name: '', email: '', photoURL: '' },
         phone: localStorage.getItem('userPhone') || '',
         
         saveName() {
             localStorage.setItem('currentUser', JSON.stringify(this.user));
             alert('Nama berhasil disimpan!');
             // Dispatch event to update sidebar immediately
             window.dispatchEvent(new CustomEvent('user-updated', { detail: this.user }));
         },
         
         savePhone() {
             localStorage.setItem('userPhone', this.phone);
             alert('Nomor HP berhasil disimpan!');
         }
     }">
    
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan</h1>
        <p class="text-gray-500">Kelola profil, langganan, dan pengaturan lainnya.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Menu -->
        <div class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <nav class="flex flex-col p-2 space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-green-700 bg-green-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Profil
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                        </svg>
                        Billing
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Afiliasi
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Akun</h2>

                <div class="space-y-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="flex gap-3">
                            <input type="text" x-model="user.name" class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <button @click="saveName" class="bg-green-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                Simpan
                            </button>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" x-model="user.email" disabled class="w-full border border-gray-300 bg-gray-50 text-gray-500 rounded-lg px-4 py-2.5 text-sm mb-1">
                        <p class="text-xs text-gray-500">Email tidak dapat diubah.</p>
                    </div>

                    <!-- Nomor HP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP</label>
                        <div class="flex gap-3">
                            <input type="tel" x-model="phone" placeholder="08..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <button @click="savePhone" class="bg-green-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg flex gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500 flex-shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <div>
                    <h3 class="text-sm font-bold text-blue-900 mb-1">Login dengan Akun Pihak Ketiga</h3>
                    <p class="text-sm text-blue-700">
                        Anda masuk menggunakan akun Google. Untuk mengubah password, silakan lakukan melalui pengaturan keamanan akun Google Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
