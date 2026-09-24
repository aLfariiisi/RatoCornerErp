@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Kategori Produk</h1>
        <p class="text-sm text-gray-500">Kelola kategori produk toko dan sistem ERP Anda.</p>
    </div>
    <!-- Tombol Trigger Modal Tambah Kategori -->
    <button onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Kategori
    </button>
</div>

<!-- Tabel Daftar Kategori -->
<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6">Gambar</th>
                <th class="py-3 px-6">Nama Kategori</th>
                <th class="py-3 px-6">Slug</th>
                <th class="py-3 px-6">Deskripsi</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6">
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="w-10 h-10 object-cover rounded-md border">
                    @else
                        <span class="text-xs text-gray-400 italic">No Image</span>
                    @endif
                </td>
                <td class="py-4 px-6 font-semibold text-gray-800">{{ $category->name }}</td>
                <td class="py-4 px-6 text-gray-500">{{ $category->slug }}</td>
                <td class="py-4 px-6 text-gray-600">{{ Str::limit($category->description, 40) }}</td>
                <td class="py-4 px-6 text-center space-x-3 flex justify-center items-center">
                    <!-- Tombol Edit (Trigger Modal Edit) -->
                    <button type="button" onclick="document.getElementById('editCategoryModal-{{ $category->id }}').classList.remove('hidden')" class="text-blue-500 hover:text-blue-700 text-sm font-medium transition" title="Edit Kategori">
                        <i class="fa-solid fa-edit"></i>
                    </button>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium transition" title="Hapus Kategori">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>

            <!-- ================= MODAL EDIT KATEGORI UNTUK SETIAP BARIS ================= -->
            <div id="editCategoryModal-{{ $category->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Edit Kategori</h3>
                        <button type="button" onclick="document.getElementById('editCategoryModal-{{ $category->id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Wajib untuk edit -->
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" name="name" value="{{ $category->name }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">{{ $category->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Kategori</label>
                            @if($category->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $category->image) }}" class="w-16 h-16 object-cover rounded border">
                                </div>
                            @endif
                            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100">
                            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah gambar.</p>
                        </div>
                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" onclick="document.getElementById('editCategoryModal-{{ $category->id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-primary hover:bg-opacity-90 text-white rounded-lg text-sm font-medium transition">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ================= AKHIR MODAL EDIT ================= -->

            @empty
            <tr>
                <td colspan="5" class="py-6 text-center text-gray-400">Belum ada kategori tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $categories->links() }}
    </div>
</div>

<!-- Modal Tambah Kategori Sesuai CategoryController@store -->
<div id="addCategoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Kategori Baru</h3>
            <button onclick="document.getElementById('addCategoryModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Kategori</label>
                <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="document.getElementById('addCategoryModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-opacity-90 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection