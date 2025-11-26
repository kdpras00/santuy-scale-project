@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Rekap Penjualan</h1>
            <p class="text-gray-600">Ringkasan performa penjualan bisnis Anda.</p>
        </div>
        <div class="flex gap-2">
            <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-green-500 focus:border-green-500">
                <option>Hari Ini</option>
                <option>Minggu Ini</option>
                <option>Bulan Ini</option>
                <option>Tahun Ini</option>
            </select>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                Export Excel
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalTransactions }}</h3>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Produk Terjual</p>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $productsSold }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="font-bold text-lg text-gray-900">Riwayat Transaksi Terakhir</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">ID Transaksi</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">#TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $transaction->customer_name ?? 'Umum' }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($transaction->status == 'paid')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-medium">Lunas</span>
                            @elseif($transaction->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Pending</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">Batal</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:underline">Detail</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-100 bg-gray-50 text-center">
            <a href="{{ route('cashflow') }}" class="text-sm text-gray-600 font-medium hover:text-gray-900">Lihat Semua Transaksi</a>
        </div>
    </div>
</div>
@endsection
