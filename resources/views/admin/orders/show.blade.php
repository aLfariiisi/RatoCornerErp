@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan: {{ $order->order_number }}</h1>
        <p class="text-sm text-gray-500">Dibuat pada: {{ $order->created_at->format('d M Y H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Kolom Kiri: Daftar Produk yang Dipesan -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Item Produk</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                        <th class="py-3 px-4">Produk</th>
                        <th class="py-3 px-4 text-center">Jumlah</th>
                        <th class="py-3 px-4 text-right">Harga Satuan</th>
                        <th class="py-3 px-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                        <td class="py-3 px-4 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 px-4 text-right text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right font-medium text-primary">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 pt-4 border-t flex justify-between items-center font-bold text-lg text-gray-800">
                <span>Total Harga:</span>
                <span class="text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Form Update Status Pesanan & Resi (Sesuai OrderController@updateStatus) -->
        <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Perbarui Status & Resi Pesanan</h3>
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pesanan</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-primary">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Processed</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Resi Pengiriman</label>
                        <input type="text" name="tracking_number" value="{{ $order->shipping->tracking_number ?? '' }}" placeholder="Masukkan No. Resi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-opacity-90 transition">Simpan Perubahan Status</button>
            </form>
        </div>
    </div>

    <!-- Kolom Kanan: Informasi Pelanggan, Pembayaran, & Pengiriman -->
    <div class="space-y-6">
        <!-- Info Pelanggan -->
        <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
            <h3 class="text-md font-bold text-gray-800 mb-3 border-b pb-2">Informasi Pelanggan</h3>
            <p class="text-sm font-semibold text-gray-800">{{ $order->user->name ?? 'Guest' }}</p>
            <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
        </div>

        <!-- Info Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
            <h3 class="text-md font-bold text-gray-800 mb-3 border-b pb-2">Informasi Pembayaran</h3>
            <p class="text-sm text-gray-600 mb-1"><span class="font-medium text-gray-800">Metode:</span> {{ $order->payment->payment_method ?? '-' }}</p>
            <p class="text-sm text-gray-600"><span class="font-medium text-gray-800">Status:</span> 
                <span class="font-semibold {{ ($order->payment->payment_status ?? '') == 'success' ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ ucfirst($order->payment->payment_status ?? 'Pending') }}
                </span>
            </p>
        </div>

        <!-- Info Pengiriman -->
        <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
            <h3 class="text-md font-bold text-gray-800 mb-3 border-b pb-2">Informasi Pengiriman</h3>
            <p class="text-sm text-gray-600 mb-1"><span class="font-medium text-gray-800">Kurir:</span> {{ $order->shipping->shipping_method ?? '-' }}</p>
            <p class="text-sm text-gray-600 mb-1"><span class="font-medium text-gray-800">Alamat:</span> {{ $order->shipping->shipping_address ?? '-' }}</p>
            <p class="text-sm text-gray-600"><span class="font-medium text-gray-800">No. Resi:</span> {{ $order->shipping->tracking_number ?? 'Belum ada' }}</p>
        </div>
    </div>

</div>
@endsection