@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Kalkulator HPP Otomatis</h1>
        <p class="text-gray-600">Hitung Harga Pokok Penjualan (HPP) dengan akurat untuk menentukan harga jual.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Calculator Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Material Costs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs">1</span>
                    Biaya Bahan Baku
                </h2>
                <div class="space-y-3" id="material-list">
                    <div class="flex gap-4 items-end material-item">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Nama Bahan</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Contoh: Tepung Terigu">
                        </div>
                        <div class="w-32">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Biaya (Rp)</label>
                            <input type="number" class="material-cost w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="0">
                        </div>
                        <button class="text-red-500 hover:bg-red-50 p-2 rounded-lg" onclick="this.closest('.material-item').remove(); calculateHPP()">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
                <button id="add-material-btn" class="mt-3 text-sm text-green-600 font-medium hover:underline flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Bahan
                </button>
            </div>

            <!-- Labor Costs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">2</span>
                    Biaya Tenaga Kerja
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Upah per Jam</label>
                        <input type="number" id="wage" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Waktu Pengerjaan (Jam)</label>
                        <input type="number" id="hours" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="0">
                    </div>
                </div>
            </div>

            <!-- Overhead Costs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-xs">3</span>
                    Biaya Overhead & Lainnya
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Listrik & Air</label>
                        <input type="number" id="utility" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kemasan</label>
                        <input type="number" id="packaging" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h2 class="font-bold text-gray-900 mb-6">Ringkasan HPP</h2>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Bahan Baku</span>
                        <span class="font-medium" id="totalMaterial">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Tenaga Kerja</span>
                        <span class="font-medium" id="totalLabor">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Overhead</span>
                        <span class="font-medium" id="totalOverhead">Rp 0</span>
                    </div>
                    <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total HPP</span>
                        <span class="font-bold text-xl text-green-600" id="totalHPP">Rp 0</span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Margin Keuntungan (%)</label>
                    <input type="range" id="marginRange" min="0" max="100" value="30" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-green-600 mb-2">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500" id="marginPercentDisplay">30%</span>
                        <span class="font-bold text-green-600" id="marginAmount">Rp 0</span>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-500 mb-1">Rekomendasi Harga Jual</p>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6" id="sellingPrice">Rp 0</h3>
                    
                    <form action="{{ route('hpp-calculator.store') }}" method="POST">
                        @csrf
                        <!-- Hidden inputs to send calculated data -->
                        <input type="hidden" name="total_material" id="inputTotalMaterial">
                        <input type="hidden" name="total_labor" id="inputTotalLabor">
                        <input type="hidden" name="total_overhead" id="inputTotalOverhead">
                        <input type="hidden" name="total_hpp" id="inputTotalHPP">
                        <input type="hidden" name="margin_percent" id="inputMarginPercent">
                        <input type="hidden" name="selling_price" id="inputSellingPrice">
                        
                        <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-3 font-bold hover:bg-green-700 transition-colors shadow-lg shadow-green-200" onclick="prepareSubmission()">
                            Simpan Perhitungan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Helper to format currency
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        }

        // Helper to parse currency input
        const parseInput = (element) => {
            return parseFloat(element?.value) || 0;
        }

        window.calculateHPP = function() {
            // 1. Material Costs
            let totalMaterial = 0;
            document.querySelectorAll('.material-cost').forEach(input => {
                totalMaterial += parseInput(input);
            });

            // 2. Labor Costs
            const wage = parseInput(document.getElementById('wage'));
            const hours = parseInput(document.getElementById('hours'));
            const totalLabor = wage * hours;

            // 3. Overhead Costs
            const utility = parseInput(document.getElementById('utility'));
            const packaging = parseInput(document.getElementById('packaging'));
            const totalOverhead = utility + packaging;

            // Total HPP
            const totalHPP = totalMaterial + totalLabor + totalOverhead;

            // Margin
            const marginRange = document.getElementById('marginRange');
            const marginPercent = parseInt(marginRange.value);
            const marginAmount = totalHPP * (marginPercent / 100);
            const sellingPrice = totalHPP + marginAmount;

            // Update UI
            document.getElementById('totalMaterial').textContent = formatRupiah(totalMaterial);
            document.getElementById('totalLabor').textContent = formatRupiah(totalLabor);
            document.getElementById('totalOverhead').textContent = formatRupiah(totalOverhead);
            document.getElementById('totalHPP').textContent = formatRupiah(totalHPP);
            document.getElementById('marginAmount').textContent = formatRupiah(marginAmount);
            document.getElementById('sellingPrice').textContent = formatRupiah(sellingPrice);
            document.getElementById('marginPercentDisplay').textContent = marginPercent + '%';
        }

        // Add Material
        document.getElementById('add-material-btn').addEventListener('click', function() {
            const container = document.getElementById('material-list');
            const newItem = document.createElement('div');
            newItem.className = 'flex gap-4 items-end material-item mt-3';
            newItem.innerHTML = `
                <div class="flex-1">
                    <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Contoh: Bahan Baru">
                </div>
                <div class="w-32">
                    <input type="number" class="material-cost w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="0" oninput="calculateHPP()">
                </div>
                <button class="text-red-500 hover:bg-red-50 p-2 rounded-lg" onclick="this.closest('.material-item').remove(); calculateHPP()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            `;
            container.appendChild(newItem);
        });

        // Add event listeners to all inputs (including dynamically added ones via event delegation)
        document.body.addEventListener('input', function(e) {
            // Check if the event target is an input or range element
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'RANGE') {
                calculateHPP();
            }
        });

        // Initial Calc
        calculateHPP();

        // Prepare data for submission
        window.prepareSubmission = function() {
            // Recalculate to be sure
            calculateHPP();
            
            // Get raw values (remove Rp and dots if needed, but here we calculate fresh)
            // 1. Material Costs
            let totalMaterial = 0;
            document.querySelectorAll('.material-cost').forEach(input => {
                totalMaterial += parseInput(input);
            });

            // 2. Labor Costs
            const wage = parseInput(document.getElementById('wage'));
            const hours = parseInput(document.getElementById('hours'));
            const totalLabor = wage * hours;

            // 3. Overhead Costs
            const utility = parseInput(document.getElementById('utility'));
            const packaging = parseInput(document.getElementById('packaging'));
            const totalOverhead = utility + packaging;

            // Total HPP
            const totalHPP = totalMaterial + totalLabor + totalOverhead;

            // Margin
            const marginRange = document.getElementById('marginRange');
            const marginPercent = parseInt(marginRange.value);
            const marginAmount = totalHPP * (marginPercent / 100);
            const sellingPrice = totalHPP + marginAmount;

            // Set hidden inputs
            document.getElementById('inputTotalMaterial').value = totalMaterial;
            document.getElementById('inputTotalLabor').value = totalLabor;
            document.getElementById('inputTotalOverhead').value = totalOverhead;
            document.getElementById('inputTotalHPP').value = totalHPP;
            document.getElementById('inputMarginPercent').value = marginPercent;
            document.getElementById('inputSellingPrice').value = sellingPrice;
        }
    });
</script>
@endpush
