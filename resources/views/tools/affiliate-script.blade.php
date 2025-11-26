@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Affiliate Script Generator</h1>
        <p class="text-gray-600">Buat skrip promosi afiliasi yang menarik untuk media sosial.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('generated_script'))
        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-900">Hasil Script:</h3>
                <button onclick="copyScript()" class="text-sm text-green-600 hover:text-green-700 font-medium flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                    </svg>
                    Salin Script
                </button>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4 font-mono text-sm text-gray-700 whitespace-pre-wrap break-words" id="generatedScript">{{ session('generated_script') }}</div>
        </div>
        <script>
            function copyScript() {
                const scriptText = document.getElementById('generatedScript').innerText;
                navigator.clipboard.writeText(scriptText).then(() => {
                    alert('Script berhasil disalin!');
                });
            }
        </script>
        @endif

        <form action="{{ route('affiliate-script-generator.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Link Produk Afiliasi</label>
                <input type="url" name="product_link" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="https://shopee.co.id/produk..." required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Platform Target</label>
                <div class="grid grid-cols-3 gap-4">
                    <label class="border border-gray-200 rounded-lg p-3 flex items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <input type="radio" name="platform" value="TikTok" class="hidden" checked>
                        <span class="text-sm font-medium">TikTok</span>
                    </label>
                    <label class="border border-gray-200 rounded-lg p-3 flex items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <input type="radio" name="platform" value="Instagram Reels" class="hidden">
                        <span class="text-sm font-medium">Instagram Reels</span>
                    </label>
                    <label class="border border-gray-200 rounded-lg p-3 flex items-center justify-center gap-2 cursor-pointer hover:bg-gray-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <input type="radio" name="platform" value="Twitter" class="hidden">
                        <span class="text-sm font-medium">Twitter / X</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Poin Keunggulan (Pisahkan dengan koma)</label>
                <textarea name="benefits" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Diskon 50%, Gratis Ongkir, Bahan Premium..." required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tone Bahasa</label>
                <select name="tone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                    <option value="Santai & Akrab">Santai & Akrab</option>
                    <option value="Profesional & Meyakinkan">Profesional & Meyakinkan</option>
                    <option value="Hype & Semangat">Hype & Semangat</option>
                    <option value="Storytelling / Bercerita">Storytelling / Bercerita</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-3 font-bold hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                </svg>
                Generate & Simpan Script
            </button>
        </form>
    </div>
</div>
@endsection
