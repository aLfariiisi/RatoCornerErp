@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Role')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna Sistem</h1>
        <p class="text-sm text-gray-500">Kelola hak akses dan akun administrator/pengguna.</p>
    </div>
    <button onclick="document.getElementById('addUserModal').classList.remove('hidden')" class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        <i class="fa-solid fa-user-shield mr-1"></i> Tambah Pengguna Baru
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6">Nama</th>
                <th class="py-3 px-6">Email</th>
                <th class="py-3 px-6">Role / Hak Akses</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-semibold text-gray-800">{{ $user->name }}</td>
                <td class="py-4 px-6 text-gray-600">{{ $user->email }}</td>
                <td class="py-4 px-6">
                    @foreach($user->roles as $role)
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-primary">
                            {{ ucfirst($role->name) }}
                        </span>
                    @endforeach
                </td>
                <td class="py-4 px-6 text-center">
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 text-center text-gray-400">Belum ada data pengguna sistem.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>

<!-- Modal Tambah Pengguna & Role (Sesuai UserController@store) -->
<div id="addUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Pengguna Baru</h3>
            <button onclick="document.getElementById('addUserModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.users.store') }}" method="POST">
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
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role / Hak Akses</label>
                <select name="role" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-primary">
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addUserModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection