@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Cashflow Bisnis</h1>
            <p class="text-gray-600">Pantau arus kas masuk dan keluar secara real-time.</p>
        </div>
        <button onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Catat Transaksi
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Pemasukan Bulan Ini</p>
            <h3 class="text-2xl font-bold text-green-600">+ Rp {{ number_format($income, 0, ',', '.') }}</h3>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                </svg>
                12% dari bulan lalu
            </p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Pengeluaran Bulan Ini</p>
            <h3 class="text-2xl font-bold text-red-600">- Rp {{ number_format($expense, 0, ',', '.') }}</h3>
            <p class="text-xs text-red-600 mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18" />
                </svg>
                5% dari bulan lalu
            </p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Saldo Bersih</p>
            <h3 class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
            <p class="text-xs text-gray-400 mt-2">Update terakhir: Baru saja</p>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h2 class="font-bold text-lg text-gray-900 mb-4">Grafik Arus Kas (30 Hari Terakhir)</h2>
        <div class="h-80 w-full">
            <canvas id="cashflowChart"></canvas>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h2 class="font-bold text-lg text-gray-900">Transaksi Terakhir</h2>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($cashflows as $flow)
            <div class="p-4 flex justify-between items-center hover:bg-gray-50">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full {{ $flow->type == 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} flex items-center justify-center">
                        @if($flow->type == 'income')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                        </svg>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $flow->description }}</h4>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($flow->date)->format('d M Y') }} • {{ $flow->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}</p>
                    </div>
                </div>
                <span class="font-bold {{ $flow->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $flow->type == 'income' ? '+' : '-' }} Rp {{ number_format($flow->amount, 0, ',', '.') }}
                </span>
            </div>
            @empty
            <div class="p-4 text-center text-gray-500">Belum ada data cashflow.</div>
            @endforelse
        </div>
    </div>
    </div>
</div>

<!-- Add Transaction Modal -->
<div id="addTransactionModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Catat Transaksi Baru</h3>
            <button onclick="document.getElementById('addTransactionModal').classList.add('hidden'); document.getElementById('addTransactionModal').classList.remove('flex')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('cashflow.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="income" class="text-green-600 focus:ring-green-500" checked>
                            <span class="text-sm">Pemasukan</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="type" value="expense" class="text-red-600 focus:ring-red-500">
                            <span class="text-sm">Pengeluaran</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="description" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" placeholder="Contoh: Penjualan Harian" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                    <input type="number" name="amount" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="Operasional">Operasional</option>
                        <option value="Penjualan">Penjualan</option>
                        <option value="Gaji">Gaji</option>
                        <option value="Bahan Baku">Bahan Baku</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2.5 font-medium hover:bg-green-700 transition-colors">
                    Simpan Transaksi
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function openModal() {
        const modal = document.getElementById('addTransactionModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('cashflowChart').getContext('2d');
        const chartData = @json($chartData);

        const labels = chartData.map(data => {
            const date = new Date(data.date);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        });
        const incomeData = chartData.map(data => data.income);
        const expenseData = chartData.map(data => data.expense);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: incomeData,
                        borderColor: '#16a34a', // green-600
                        backgroundColor: 'rgba(22, 163, 74, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: expenseData,
                        borderColor: '#dc2626', // red-600
                        backgroundColor: 'rgba(220, 38, 38, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
