@extends('layouts.frontend')
@section('title', 'Pembayaran')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-center font-semibold">{{ session('success') }}</div>
    @endif

    <div class="bg-white p-8 rounded-xl shadow-sm border text-center mb-8">
        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
            <i class="fas fa-check"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-500">Nomor Pesanan: <span class="font-bold text-gray-800">{{ $order->order_number }}</span></p>
    </div>

    <div class="bg-gray-50 p-8 rounded-xl shadow-sm border">
        <h2 class="text-xl font-bold border-b pb-4 mb-6">Informasi Pembayaran</h2>
        
        <div class="flex justify-between items-center mb-6">
            <span class="text-gray-600">Total yang harus dibayar:</span>
            <span class="text-3xl font-bold text-[#c28455]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        <!-- Metode Pembayaran yang Dipilih -->
        <div class="bg-white p-6 border rounded-lg mb-6">
            <h3 class="font-bold text-gray-800 mb-4">{{ $order->payment->payment_method ?? 'Transfer Bank' }}</h3>
            <div class="flex justify-between items-center bg-gray-50 p-4 rounded border">
                <div>
                    <p class="text-sm text-gray-500">Informasi Rekening / Tujuan</p>
                    <p class="font-bold text-xl tracking-wider">8732 1234 5678</p>
                    <p class="text-sm text-gray-500 mt-1">a.n. Rato Corner Indonesia</p>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded">Status: {{ ucfirst($order->status) }}</span>
            </div>
        </div>

        <!-- Detail Pengiriman -->
        <div class="bg-white p-6 border rounded-lg mb-6">
            <h3 class="font-bold text-gray-800 mb-2">Detail Pengiriman</h3>
            <p class="text-sm text-gray-600"><strong>Kurir:</strong> {{ $order->shipping->shipping_method ?? '-' }}</p>
            <p class="text-sm text-gray-600 mt-1"><strong>Alamat Tujuan:</strong> {{ $order->shipping->shipping_address ?? '-' }}</p>
        </div>

        <div class="text-sm text-gray-600 mb-8 space-y-2">
            <p><i class="fas fa-info-circle text-blue-500 mr-2"></i>Silakan lakukan pembayaran agar pesanan segera diproses oleh admin di panel ERP.</p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('dashboard') }}" class="flex-1 text-center bg-[#1a1311] hover:bg-[#c28455] text-white font-bold py-3 rounded transition">Lihat Status Pesanan</a>
            <a href="{{ route('products.index') }}" class="flex-1 text-center bg-white border border-gray-300 text-gray-700 font-bold py-3 rounded hover:bg-gray-50 transition">Belanja Lagi</a>
        </div>
    </div>
</div>
@endsection