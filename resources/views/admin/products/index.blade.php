@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Produk</h1>
        <p class="text-sm text-gray-500">Kelola inventaris produk, harga jual, dan gambar.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-[#c28455] hover:bg-[#a66a40] text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6 text-center">Gambar</th>
                <th class="py-3 px-6">SKU</th>
                <th class="py-3 px-6">Nama Produk</th>
                <th class="py-3 px-6">Kategori</th>
                <th class="py-3 px-6">Harga</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded bg-gray-100 mx-auto">
                    @else
                        <div class="w-12 h-12 bg-gray-100 flex items-center justify-center rounded mx-auto text-gray-400 text-xs">No Img</div>
                    @endif
                </td>
                <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $product->sku }}</td>
                <td class="py-4 px-6 font-semibold text-gray-800">{{ $product->name }}</td>
                <td class="py-4 px-6 text-gray-600">{{ $product->category->name ?? '-' }}</td>
                <td class="py-4 px-6 font-medium text-[#c28455]">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="py-4 px-6 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="py-4 px-6 text-center space-x-3">
                    <!-- Tombol Edit -->
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit Produk">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    
                    <!-- Tombol Hapus -->
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus produk ini beserta data stok dan gambarnya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus Produk">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-6 text-center text-gray-400">Belum ada produk terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
</div>
@endsection