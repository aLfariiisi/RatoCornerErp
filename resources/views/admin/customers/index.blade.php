@extends('layouts.admin')

@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pelanggan</h1>
        <p class="text-sm text-gray-500">Kelola akun pengguna dengan role pelanggan.</p>
    </div>
    <button onclick="document.getElementById('addCustomerModal').classList.remove('hidden')" class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        <i class="fa-solid fa-user-plus mr-1"></i> Tambah Pelanggan
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6">Nama</th>
                <th class="py-3 px-6">Email</th>
                <th class="py-3 px-6">Tanggal Terdaftar</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($customers as $customer)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-semibold text-gray-800">{{ $customer->name }}</td>
                <td class="py-4 px-6 text-gray-600">{{ $customer->email }}</td>
                <td class="py-4 px-6 text-gray-500">{{ $customer->created_at->format('d M Y') }}</td>
                <td class="py-4 px-6 text-center space-x-2">
                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="text-primary hover:underline font-medium">Detail</a>
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data pelanggan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 text-center text-gray-400">Belum ada data pelanggan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $customers->links() }}
    </div>
</div>

<!-- Modal Tambah Pelanggan (Sesuai CustomerController@store) -->
<div id="addCustomerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Pelanggan Baru</h3>
            <button onclick="document.getElementById('addCustomerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.customers.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password (Min. 8 Karakter)</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addCustomerModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection