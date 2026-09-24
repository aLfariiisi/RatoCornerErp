@extends('layouts.admin')

@section('title', 'Detail Return & Exchange')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pengembalian Barang</h1>
        <p class="text-sm text-gray-500">Invoice: {{ $returnExchange->order->order_number ?? '-' }}</p>
    </div>
    <a href="{{ route('admin.returns.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Produk yang Dikembalikan -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Produk Pesanan Terkait</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                    <th class="py-3 px-4">Produk</th>
                    <th class="py-3 px-4 text-center">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @foreach($returnExchange->order->items ?? [] as $item)
                <tr>
                    <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->product->name ?? '-' }}</td>
                    <td class="py-3 px-4 text-center">{{ $item->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Form Update Status Return (Sesuai ReturnExchangeController@updateStatus) -->
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Proses Permintaan</h3>
        <form action="{{ route('admin.returns.updateStatus', $returnExchange->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Permintaan</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-primary">
                    <option value="pending" {{ $returnExchange->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $returnExchange->status == 'approved' ? 'selected' : '' }}>Approved (Disetujui)</option>
                    <option value="rejected" {{ $returnExchange->status == 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
                    <option value="completed" {{ $returnExchange->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin</label>
                <textarea name="admin_notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">{{ $returnExchange->admin_notes }}</textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-opacity-90 transition">Perbarui Status</button>
        </form>
    </div>
</div>
@endsection