@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Panduan & Tutorial</h1>
        <p class="text-gray-600">Pelajari cara memaksimalkan setiap fitur di Santai Scale.</p>
    </div>

    <div class="space-y-8">
        <!-- Card 1: Landing Page Generator -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h2 class="font-semibold text-gray-800">Video Tutorial: Landing Page Generator</h2>
            </div>
            <div class="relative aspect-video bg-gray-900 group cursor-pointer">
                <!-- Thumbnail Placeholder -->
                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-gray-900 to-blue-900">
                    <div class="text-center text-white p-8">
                        <div class="flex items-center justify-between absolute top-4 left-4 right-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-black font-bold">U</div>
                                <span class="text-sm font-medium">Tutorial Landing Page Generator AI | Santai Scale</span>
                            </div>
                            <div class="flex items-center gap-4 text-xs">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Tonton nanti</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                                    </svg>
                                    <span>Bagikan</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-4xl font-black mb-2">CUMA ISI<br>PRODUK.</h3>
                            <h3 class="text-4xl font-black text-green-500 mb-2">LANDING PAGE<br>JADI SENDIRI</h3>
                            <p class="text-lg mt-4">AI kami bantu dari <span class="text-blue-400">headline</span>, <span class="bg-blue-600 px-1">fitur</span>, sampai <span class="bg-blue-600 px-1">CTA</span></p>
                        </div>
                        
                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-red-600 rounded-lg flex items-center justify-center shadow-lg group-hover:bg-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                                    <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="absolute bottom-4 left-4">
                    <a href="#" class="bg-black/70 text-white px-2 py-1 text-xs font-semibold rounded hover:bg-black/90 flex items-center gap-1">
                        Tonton di <svg class="w-10 h-4" viewBox="0 0 576 512" fill="currentColor"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 42.155 48.284 48.477 42.591 11.486 213.371 11.486 213.371 11.486s170.78 0 213.371-11.486c23.497-6.322 42.003-24.827 48.284-48.477 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2: WA Testimonial Generator -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h2 class="font-semibold text-gray-800">Video Tutorial: WA Testimonial Generator</h2>
            </div>
            <div class="relative aspect-video bg-gray-900 group cursor-pointer">
                <!-- Thumbnail Placeholder -->
                <div class="absolute inset-0 flex items-center justify-center bg-black">
                    <div class="text-center text-white p-8 w-full">
                        <div class="flex items-center justify-between absolute top-4 left-4 right-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-black font-bold">U</div>
                                <span class="text-sm font-medium">Whatsapp Testimonial Generator | Santai Scale</span>
                            </div>
                            <div class="flex items-center gap-4 text-xs">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Tonton nanti</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                                    </svg>
                                    <span>Bagikan</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-12">
                            <h3 class="text-5xl font-black mb-2">BUAT</h3>
                        </div>
                        
                        <!-- Play Button -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 bg-red-600 rounded-lg flex items-center justify-center shadow-lg group-hover:bg-red-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                                    <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="absolute bottom-4 left-4">
                    <a href="#" class="bg-black/70 text-white px-2 py-1 text-xs font-semibold rounded hover:bg-black/90 flex items-center gap-1">
                        Tonton di <svg class="w-10 h-4" viewBox="0 0 576 512" fill="currentColor"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 42.155 48.284 48.477 42.591 11.486 213.371 11.486 213.371 11.486s170.78 0 213.371-11.486c23.497-6.322 42.003-24.827 48.284-48.477 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
