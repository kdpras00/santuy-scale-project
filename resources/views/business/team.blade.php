@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Tim</h1>
            <p class="text-gray-600">Kelola akses dan peran anggota tim Anda.</p>
        </div>
        <button onclick="openModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3.75 17.25a4.875 4.875 0 004.875-4.875b4.875 4.875 0 00-4.875-4.875 2.25 2.25 0 012.25 2.25v.375a3 3 0 003 3h.375M21 17.25a4.875 4.875 0 00-4.875-4.875 2.25 2.25 0 012.25 2.25v.375a3 3 0 003 3h.375" />
            </svg>
            Undang Anggota
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Anggota</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Peran</th>
                        <th class="px-6 py-4">Status</th>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs font-medium">Kasir</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-medium">Undangan Terkirim</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">-</td>
                        <td class="px-6 py-4">
                            <button class="text-blue-600 hover:underline mr-3">Resend</button>
                            <button class="text-red-600 hover:underline">Batalkan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>

<!-- Invite Member Modal -->
<div id="inviteMemberModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Undang Anggota Tim</h3>
            <button onclick="document.getElementById('inviteMemberModal').classList.add('hidden'); document.getElementById('inviteMemberModal').classList.remove('flex')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('team-management.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Peran</label>
                    <select name="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="staff">Staff</option>
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white rounded-lg py-2.5 font-medium hover:bg-green-700 transition-colors">
                    Kirim Undangan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('inviteMemberModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>
@endsection
