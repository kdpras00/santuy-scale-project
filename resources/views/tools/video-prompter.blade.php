@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Video Prompter</h1>
        <p class="text-gray-600">Baca skrip dengan mudah saat merekam video.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="mb-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('video-prompter.store') }}" method="POST" id="prompterForm">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">Skrip Video</label>
                <textarea name="script_content" rows="10" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-lg focus:ring-green-500 focus:border-green-500" placeholder="Tulis atau tempel skrip Anda di sini..." required>{{ session('script_content') }}</textarea>
                
                <div class="mt-2 text-right">
                    <button type="submit" class="text-sm text-green-600 hover:underline">Simpan Skrip</button>
                </div>
            </form>
        </div>

        <div class="flex flex-wrap items-center gap-6 mb-8 p-4 bg-gray-50 rounded-lg">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Kecepatan Scroll</label>
                <input type="range" id="initialSpeed" min="1" max="10" value="5" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-green-600">
                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>Lambat</span>
                    <span>Cepat</span>
                </div>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Ukuran Font</label>
                <input type="range" id="initialSize" min="16" max="100" value="48" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-green-600">
                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>Kecil</span>
                    <span>Besar</span>
                </div>
            </div>
        </div>

        <div class="flex justify-center gap-4">
            <button class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                Reset
            </button>
            <button class="bg-red-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-red-700 transition-colors flex items-center gap-2 shadow-lg shadow-red-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                </svg>
                Mulai Prompter
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="script_content"]');
        const startButton = document.querySelector('button.bg-red-600'); 
        const resetButton = document.querySelector('button.bg-gray-100');
        
        // Initial Sliders
        const initialSpeed = document.getElementById('initialSpeed');
        const initialSize = document.getElementById('initialSize');

        // Create Overlay Elements
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black z-50 hidden flex-col';
        
        // Custom CSS for Sliders and Animation
        const style = document.createElement('style');
        style.innerHTML = `
            .custom-range {
                -webkit-appearance: none;
                width: 100%;
                height: 4px;
                background: #4b5563;
                border-radius: 2px;
                outline: none;
            }
            .custom-range::-webkit-slider-thumb {
                -webkit-appearance: none;
                appearance: none;
                width: 16px;
                height: 16px;
                background: #3b82f6; /* Blue-500 */
                border-radius: 50%;
                cursor: pointer;
            }
            .custom-range::-moz-range-thumb {
                width: 16px;
                height: 16px;
                background: #3b82f6;
                border-radius: 50%;
                cursor: pointer;
            }
            @keyframes blink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.5; }
            }
            .animate-blink {
                animation: blink 1s infinite;
            }
        `;
        document.head.appendChild(style);

        overlay.innerHTML = `
            <!-- Progress Bar (Top) -->
            <div class="w-full h-2 bg-gray-900 relative">
                <div id="progressBar" class="h-full bg-red-600 w-0 transition-all duration-100 flex items-center justify-end">
                    <!-- Arrow Head -->
                    <div class="w-0 h-0 border-t-[6px] border-t-transparent border-l-[8px] border-l-red-600 border-b-[6px] border-b-transparent translate-x-full"></div>
                </div>
            </div>

            <!-- Top Control Bar -->
            <div class="flex items-center justify-between px-6 py-4 bg-black border-b border-gray-800 w-full overflow-x-auto">
                
                <div class="flex items-center gap-8">
                    <!-- Play/Pause -->
                    <button id="togglePlay" class="group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-red-900/80 group-hover:text-red-600 transition-colors">
                            <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Icons Group -->
                    <div class="flex items-center gap-6">
                        <!-- Text Align -->
                        <button id="toggleAlign" class="text-red-900/80 hover:text-red-600">
                            <svg id="alignIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                            </svg>
                        </button>

                        <!-- Mirror -->
                        <button id="toggleMirror" class="text-red-900/80 hover:text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                        </button>
                    </div>

                    <!-- Colors -->
                    <div class="flex items-center gap-4">
                        <div class="flex flex-col items-center gap-1">
                            <div class="relative w-10 h-6 bg-gray-200 border-2 border-gray-400">
                                <input type="color" id="bgColorPicker" value="#000000" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                <div id="bgColorPreview" class="w-full h-full bg-black"></div>
                            </div>
                            <span class="text-[10px] text-red-900/60">Background color</span>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            <div class="relative w-10 h-6 bg-gray-200 border-2 border-gray-400">
                                <input type="color" id="textColorPicker" value="#ffffff" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                                <div id="textColorPreview" class="w-full h-full bg-white"></div>
                            </div>
                            <span class="text-[10px] text-red-900/60">Text color</span>
                        </div>
                    </div>

                    <!-- Sliders -->
                    <div class="flex items-center gap-6">
                        <!-- Text Size -->
                        <div class="flex flex-col items-center w-32">
                            <input type="range" id="overlaySize" min="20" max="100" value="48" class="custom-range">
                            <span id="sizeLabel" class="text-[10px] text-red-900/60 mt-1">Text size: 48px</span>
                        </div>

                        <!-- Margin -->
                        <div class="flex flex-col items-center w-32">
                            <input type="range" id="overlayMargin" min="0" max="40" value="10" class="custom-range">
                            <span id="marginLabel" class="text-[10px] text-red-900/60 mt-1">Margin: 10%</span>
                        </div>

                        <!-- Speed -->
                        <div class="flex flex-col items-center w-32">
                            <input type="range" id="overlaySpeed" min="1" max="20" value="5" class="custom-range">
                            <span id="speedLabel" class="text-[10px] text-red-900/60 mt-1">Speed: 5</span>
                        </div>
                    </div>
                </div>

                <!-- Record Button -->
                <div class="flex items-center gap-4">
                     <button id="recordBtn" class="flex items-center gap-2 border border-red-600 text-red-600 px-6 py-2 rounded hover:bg-red-600 hover:text-white transition-colors font-bold uppercase tracking-wider text-sm">
                        <span id="recordDot" class="w-3 h-3 bg-red-600 rounded-full hidden"></span>
                        <span id="recordText">Record Video</span>
                    </button>
                     <button id="closeOverlay" class="text-gray-500 hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Prompter Area -->
            <div id="prompterContainer" class="flex-1 overflow-hidden relative w-full mx-auto transition-all duration-300">
                <div id="prompterText" class="text-white font-bold text-center leading-relaxed py-[50vh] px-[10%] transition-all duration-300"></div>
                
                <!-- Reading Guide (Indicator Only) -->
                <div class="absolute top-1/2 left-4 transform -translate-y-1/2 text-red-600 z-10 text-2xl">▶</div>
            </div>
        `;
        document.body.appendChild(overlay);

        // Elements
        const prompterContainer = document.getElementById('prompterContainer');
        const prompterText = document.getElementById('prompterText');
        const progressBar = document.getElementById('progressBar');
        const togglePlay = document.getElementById('togglePlay');
        const toggleMirror = document.getElementById('toggleMirror');
        const toggleAlign = document.getElementById('toggleAlign');
        const alignIcon = document.getElementById('alignIcon');
        const overlayMargin = document.getElementById('overlayMargin');
        const overlaySize = document.getElementById('overlaySize');
        const overlaySpeed = document.getElementById('overlaySpeed');
        const bgColorPicker = document.getElementById('bgColorPicker');
        const textColorPicker = document.getElementById('textColorPicker');
        const bgColorPreview = document.getElementById('bgColorPreview');
        const textColorPreview = document.getElementById('textColorPreview');
        const closeOverlay = document.getElementById('closeOverlay');
        const recordBtn = document.getElementById('recordBtn');
        const recordDot = document.getElementById('recordDot');
        const recordText = document.getElementById('recordText');

        // Labels
        const marginLabel = document.getElementById('marginLabel');
        const sizeLabel = document.getElementById('sizeLabel');
        const speedLabel = document.getElementById('speedLabel');

        let isScrolling = false;
        let scrollInterval;
        let currentScroll = 0;
        let isMirrored = false;
        let alignState = 'center'; // center -> left -> justify
        let isRecording = false;

        // --- Event Listeners ---

        // 1. Play/Pause
        function toggleScrolling() {
            if (isScrolling) {
                stopScrolling();
            } else {
                startScrolling();
            }
        }
        togglePlay.addEventListener('click', toggleScrolling);
        // Removed prompterContainer click listener to prevent accidental pauses

        // 2. Mirror Text
        toggleMirror.addEventListener('click', () => {
            isMirrored = !isMirrored;
            prompterContainer.style.transform = isMirrored ? 'scaleX(-1)' : 'none';
        });

        // 3. Text Align
        toggleAlign.addEventListener('click', () => {
            if (alignState === 'center') {
                alignState = 'left';
                prompterText.classList.remove('text-center');
                prompterText.classList.add('text-left');
                // Icon: Left
                alignIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />';
            } else {
                alignState = 'center';
                prompterText.classList.remove('text-left');
                prompterText.classList.add('text-center');
                // Icon: Center
                alignIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M5.625 12h12.75m-12.75 5.25h16.5" />'; 
            }
        });

        // 4. Margin
        overlayMargin.addEventListener('input', (e) => {
            const val = e.target.value;
            prompterText.style.paddingLeft = val + '%';
            prompterText.style.paddingRight = val + '%';
            marginLabel.textContent = `Margin: ${val}%`;
        });

        // 5. Colors
        bgColorPicker.addEventListener('input', (e) => {
            const val = e.target.value;
            overlay.style.backgroundColor = val;
            bgColorPreview.style.backgroundColor = val;
        });
        textColorPicker.addEventListener('input', (e) => {
            const val = e.target.value;
            prompterText.style.color = val;
            textColorPreview.style.backgroundColor = val;
        });

        // 6. Size
        overlaySize.addEventListener('input', (e) => {
            const val = e.target.value;
            prompterText.style.fontSize = val + 'px';
            sizeLabel.textContent = `Text size: ${val}px`;
        });

        // 7. Speed
        overlaySpeed.addEventListener('input', (e) => {
            const val = e.target.value;
            speedLabel.textContent = `Speed: ${val}`;
            if (isScrolling) startScrolling(); 
        });

        // 8. Record Button
        recordBtn.addEventListener('click', () => {
            isRecording = !isRecording;
            if (isRecording) {
                recordText.textContent = 'Stop Recording';
                recordDot.classList.remove('hidden');
                recordDot.classList.add('animate-blink');
                recordBtn.classList.add('bg-red-600', 'text-white');
            } else {
                recordText.textContent = 'Record Video';
                recordDot.classList.add('hidden');
                recordDot.classList.remove('animate-blink');
                recordBtn.classList.remove('bg-red-600', 'text-white');
            }
            // Do NOT pause scrolling
        });

        // Start Prompter
        startButton.addEventListener('click', function() {
            if (!textarea.value.trim()) {
                alert('Silakan masukkan skrip terlebih dahulu!');
                return;
            }
            
            // Sync Initial Settings to Overlay
            const initSpeedVal = initialSpeed.value;
            const initSizeVal = initialSize.value;

            overlaySpeed.value = initSpeedVal;
            speedLabel.textContent = `Speed: ${initSpeedVal}`;

            overlaySize.value = initSizeVal;
            sizeLabel.textContent = `Text size: ${initSizeVal}px`;
            prompterText.style.fontSize = initSizeVal + 'px';

            prompterText.innerText = textarea.value;
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            prompterContainer.scrollTop = 0;
            currentScroll = 0;
            progressBar.style.width = '0%'; // Reset progress
            startScrolling();
        });

        // Close Overlay
        closeOverlay.addEventListener('click', function() {
            stopScrolling();
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            // Reset recording state
            isRecording = false;
            recordText.textContent = 'Record Video';
            recordDot.classList.add('hidden');
            recordBtn.classList.remove('bg-red-600', 'text-white');
        });

        // --- Scrolling Logic ---
        function startScrolling() {
            clearInterval(scrollInterval);
            
            // Auto-restart if at end
            const totalHeight = prompterContainer.scrollHeight - prompterContainer.clientHeight;
            if (currentScroll >= totalHeight) {
                currentScroll = 0;
                prompterContainer.scrollTop = 0;
                progressBar.style.width = '0%';
            }

            isScrolling = true;
            
            // Pause Icon
            togglePlay.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-red-600"><path fill-rule="evenodd" d="M6.75 5.25a.75.75 0 01.75-.75H9a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H7.5a.75.75 0 01-.75-.75V5.25zm7.5 0A.75.75 0 0115 4.5h1.5a.75.75 0 01.75.75v13.5a.75.75 0 01-.75.75H15a.75.75 0 01-.75-.75V5.25z" clip-rule="evenodd" /></svg>';
            
            const speed = 21 - parseInt(overlaySpeed.value); // Invert: 1 (slow) -> 20ms, 20 (fast) -> 1ms
            
            scrollInterval = setInterval(() => {
                currentScroll += 1;
                prompterContainer.scrollTop = currentScroll;

                // Update Progress Bar
                const totalHeight = prompterContainer.scrollHeight - prompterContainer.clientHeight;
                const progress = (currentScroll / totalHeight) * 100;
                progressBar.style.width = Math.min(progress, 100) + '%';

                if (currentScroll >= totalHeight) {
                    stopScrolling();
                }
            }, speed * 2); 
        }

        function stopScrolling() {
            isScrolling = false;
            clearInterval(scrollInterval);
            // Play Icon
            togglePlay.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-red-900/80 hover:text-red-600 transition-colors"><path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" /></svg>';
        }

        resetButton.addEventListener('click', function() {
            textarea.value = '';
        });
    });
</script>
@endpush
