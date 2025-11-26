@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">WA Testimonial Generator</h1>
        <p class="text-gray-600">Buat screenshot testimoni WhatsApp palsu untuk kebutuhan marketing.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('wa-testimonial-generator.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" enctype="multipart/form-data">
                @csrf
                <h2 class="text-lg font-semibold mb-4">Detail Chat</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengirim</label>
                        <input type="text" id="nameInput" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" value="Budi Santoso" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden">
                                <img id="profilePreview" src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" alt="Avatar" class="w-full h-full object-cover">
                            </div>
                            <label class="text-sm text-green-600 font-medium hover:underline cursor-pointer">
                                Ubah Foto
                                <input type="file" id="photoInput" name="photo" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Testimoni</label>
                        <textarea id="messageInput" name="message" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" required>Barang sudah sampai gan, mantap banget kualitasnya! Pengiriman juga cepet. Next order lagi ya 👍</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Chat</label>
                        <input type="text" id="timeInput" name="time" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" value="19:30" required>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-3 font-bold hover:bg-green-700 transition-colors shadow-lg shadow-green-200 mt-4">
                        Simpan & Download Gambar
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-2">*Fitur download otomatis akan aktif setelah simpan.</p>
                </div>
            </form>
        </div>

        <!-- Preview -->
        <div class="flex justify-center items-start">
            <div class="bg-[#ECE5DD] w-[380px] h-[600px] rounded-[30px] border-[8px] border-gray-800 shadow-2xl overflow-hidden relative">
                <!-- Status Bar -->
                <div class="bg-[#005e54] h-6 w-full"></div>
                
                <!-- Header -->
                <div class="bg-[#008069] px-4 py-2 flex items-center gap-3 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-300">
                        <img id="headerAvatar" src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div id="headerName" class="font-semibold text-sm">Budi Santoso</div>
                        <div class="text-[10px] opacity-80">Online</div>
                    </div>
                    <div class="flex gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 5.25V4.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Chat Area -->
                <div class="p-4 bg-[url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png')] h-full">
                    <div class="bg-white p-2 rounded-lg rounded-tl-none shadow-sm max-w-[80%] text-sm relative mb-2">
                        <div class="absolute -left-2 top-0 w-0 h-0 border-t-[10px] border-t-white border-l-[10px] border-l-transparent"></div>
                        <p id="chatMessage" class="text-gray-800">Barang sudah sampai gan, mantap banget kualitasnya! Pengiriman juga cepet. Next order lagi ya 👍</p>
                        <div id="chatTime" class="text-[10px] text-gray-400 text-right mt-1">19:30</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inputs
        const nameInput = document.getElementById('nameInput');
        const messageInput = document.getElementById('messageInput');
        const timeInput = document.getElementById('timeInput');
        const photoInput = document.getElementById('photoInput');
        
        // Preview Elements
        const headerName = document.getElementById('headerName');
        const chatMessage = document.getElementById('chatMessage');
        const chatTime = document.getElementById('chatTime');
        const headerAvatar = document.getElementById('headerAvatar');
        const profilePreview = document.getElementById('profilePreview');

        // Update Name
        nameInput.addEventListener('input', function() {
            headerName.textContent = this.value;
            // Only update avatar from name if no custom photo is uploaded
            if (!photoInput.files || photoInput.files.length === 0) {
                const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(this.value)}&background=random`;
                headerAvatar.src = avatarUrl;
                profilePreview.src = avatarUrl;
            }
        });

        // Update Message
        messageInput.addEventListener('input', function() {
            chatMessage.textContent = this.value;
        });

        // Update Time with Auto-formatting
        timeInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, ''); // Remove non-digits
            if (value.length > 4) value = value.slice(0, 4); // Limit to 4 digits

            if (value.length > 2) {
                value = value.slice(0, 2) + ':' + value.slice(2);
            }

            this.value = value;
            chatTime.textContent = value || '19:30';
        });

        // Update Photo
        photoInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    headerAvatar.src = e.target.result;
                    profilePreview.src = e.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    });
</script>
@endpush
