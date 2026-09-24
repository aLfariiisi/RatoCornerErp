@extends('layouts.admin')

@section('title', 'Manajemen Stok')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Stok Gudang</h1>
    <p class="text-sm text-gray-500">Pantau ketersediaan barang dan batas minimum peringatan stok.</p>
</div>

<!-- Peringatan Stok Rendah -->
@if($lowStocks->count() > 0)
<div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 text-red-700">
    <div class="flex items-center gap-2 font-bold mb-1">
        <i class="fa-solid fa-triangle-exclamation"></i> Peringatan Stok Menipis!
    </div>
    <p class="text-xs">Terdapat {{ $lowStocks->count() }} produk yang jumlah stoknya berada di bawah batas minimum.</p>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6">Nama Produk</th>
                <th class="py-3 px-6">SKU</th>
                <th class="py-3 px-6 text-center">Jumlah Stok</th>
                <th class="py-3 px-6 text-center">Min. Alert</th>
                <th class="py-3 px-6 text-center">Aksi / Update Stok</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($stocks as $stock)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-semibold text-gray-800">{{ $stock->product->name ?? '-' }}</td>
                <td class="py-4 px-6 font-mono text-xs text-gray-500">{{ $stock->product->sku ?? '-' }}</td>
                <td class="py-4 px-6 text-center font-bold {{ $stock->quantity <= $stock->min_stock_alert ? 'text-red-500' : 'text-gray-700' }}">
                    {{ $stock->quantity }}
                </td>
                <td class="py-4 px-6 text-center text-gray-500">{{ $stock->min_stock_alert }}</td>
                <td class="py-4 px-6 text-center">
                    <!-- Form Update Stok Sesuai StockController@update -->
                    <form action="{{ route('admin.stocks.update', $stock->id) }}" method="POST" class="flex justify-center items-center gap-2">
                        @csrf
                        @method('PUT')
                        <input type="number" name="quantity" value="1" min="1" class="w-16 border rounded px-2 py-1 text-xs text-center">
                        <select name="type" class="border rounded px-2 py-1 text-xs bg-white">
                            <option value="addition">Tambah</option>
                            <option value="subtraction">Kurang</option>
                            <option value="adjustment">Set Total</option>
                        </select>
                        <input type="hidden" name="min_stock_alert" value="{{ $stock->min_stock_alert }}">
                        <button type="submit" class="bg-primary text-white px-3 py-1 rounded text-xs font-medium hover:bg-opacity-90">Update</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-6 text-center text-gray-400">Data stok belum tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $stocks->links() }}
    </div>
</div>
@endsection