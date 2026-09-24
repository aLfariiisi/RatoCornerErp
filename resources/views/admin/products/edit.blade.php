@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-xl bg-white rounded-xl shadow-sm border border-orange-100 p-6">
    <h1 class="text-xl font-bold text-gray-800 mb-4">Form Edit Produk</h1>
    
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- INI WAJIB ADA UNTUK EDIT -->

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
            @if($product->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="h-24 w-24 object-cover rounded border">
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#c28455]">
            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#c28455]">
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">SKU (Kode Unik)</label>
            <input type="text" value="{{ $product->sku }}" disabled class="w-full border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-500 cursor-not-allowed">
            <p class="text-xs text-gray-400 mt-1">SKU tidak dapat diubah setelah produk dibuat.</p>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#c28455] bg-white">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
            <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#c28455]">
        </div>
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#c28455]">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-6 flex items-center">
            <input type="checkbox" name="is_active" value="1" id="is_active" {{ $product->is_active ? 'checked' : '' }} class="h-4 w-4 text-[#c28455] focus:ring-[#c28455] border-gray-300 rounded">
            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                Produk Aktif (Tampilkan di Katalog Frontend)
            </label>
        </div>
        
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200">Batal</a>
            <button type="submit" class="px-4 py-2 bg-[#c28455] text-white rounded-lg text-sm font-medium hover:bg-[#a66a40]">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection