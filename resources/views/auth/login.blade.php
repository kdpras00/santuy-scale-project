<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name', 'Santai Scale') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen" 
      x-data="{ 
          isLoading: false,
          progress: 0,
          handleLogin() {
              this.startLoading();
          },
          loginWithGoogle() {
              if (window.authFunctions) {
                  window.authFunctions.loginWithGoogle(this);
              } else {
                  alert('Firebase belum siap, silakan tunggu sebentar.');
              }
          },
          startLoading() {
              this.isLoading = true;
              this.progress = 0;
              
              const duration = 2000; // 2 seconds
              const interval = 20; // Update every 20ms
              const steps = duration / interval;
              const increment = 100 / steps;

              const timer = setInterval(() => {
                  this.progress += increment;
                  if (this.progress >= 100) {
                      this.progress = 100;
                      clearInterval(timer);
                      setTimeout(() => {
                          window.location.href = '{{ route('dashboard') }}';
                      }, 500);
                  }
              }, interval);
          }
      }"
      x-cloak>
    <!-- Loading Overlay -->
    <div x-show="isLoading" class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4 animate-pulse">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="w-8 h-8 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h2 class="text-xl font-bold text-gray-900 mb-2">Sedang Memuat...</h2>
        <p class="text-sm text-gray-500 mb-8">Masuk untuk melanjutkan ke Santai Scale.</p>
        
        <div class="w-64 bg-gray-200 rounded-full h-2.5 mb-2 overflow-hidden">
            <div class="bg-green-500 h-2.5 rounded-full transition-all duration-75 ease-out" :style="'width: ' + progress + '%'"></div>
        </div>
        <p class="text-xs text-gray-400" x-text="progress >= 100 ? 'Selesai! Membuka aplikasi... 100%' : 'Memuat... ' + Math.round(progress) + '%'">Memuat... 0%</p>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm w-full max-w-md" x-show="!isLoading">
        <div class="flex flex-col items-center mb-6">
            <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white mb-4">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-900">Selamat Datang Kembali</h1>
            <p class="text-sm text-gray-500">Masuk untuk melanjutkan ke Santai Scale.</p>
        </div>

        <button @click="loginWithGoogle" type="button" class="w-full flex items-center justify-center gap-2 border border-gray-300 rounded-lg py-2.5 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors mb-6">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Masuk dengan Google
        </button>

        <div class="relative mb-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="bg-white px-2 text-gray-400">ATAU</span>
            </div>
        </div>

        <form @submit.prevent="handleLogin" class="space-y-4">
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-xs font-semibold text-gray-700">Password</label>
                    <a href="#" class="text-xs text-green-500 hover:text-green-600 font-medium">Lupa password?</a>
                </div>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-green-700 transition-colors shadow-sm">
                Masuk
            </button>
        </form>

        <div class="mt-6 text-center text-xs">
            <span class="text-green-600 font-medium cursor-pointer hover:underline">Belum punya akun? Daftar</span>
        </div>
    </div>

    <!-- Alpine & Firebase Logic -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
        import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "{{ env('FIREBASE_API_KEY') }}",
            authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
            projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
            storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
            messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
            appId: "{{ env('FIREBASE_APP_ID') }}",
            measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const provider = new GoogleAuthProvider();

        // Expose auth functions to window for Alpine
        window.authFunctions = {
            loginWithGoogle: (alpineComponent) => {
                signInWithPopup(auth, provider)
                    .then((result) => {
                        const user = result.user;
                        console.log("Logged in with Google:", user);
                        
                        // Save user info to localStorage
                        const userInfo = {
                            name: user.displayName,
                            email: user.email,
                            photoURL: user.photoURL
                        };
                        localStorage.setItem('currentUser', JSON.stringify(userInfo));

                        alpineComponent.startLoading();
                    }).catch((error) => {
                        console.error("Login error:", error.code, error.message);
                        alert("Gagal masuk dengan Google: " + error.message);
                    });
            }
        };
    </script>
</body>
</html>
