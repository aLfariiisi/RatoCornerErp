@extends('layouts.frontend')
@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8">Checkout Pesanan</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf
        
        <!-- Form Informasi Meja & Pembayaran -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 border-b pb-2">Informasi Pemesanan</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nomor Meja</label>
                <input type="number" min="1" max="50" name="nomor_meja" required class="w-full border p-2 rounded focus:outline-none focus:border-[#c28455]" placeholder="Contoh: 12" value="{{ old('nomor_meja') }}">
            </div>

            <h2 class="text-xl font-semibold mb-4 mt-8 border-b pb-2">Metode Pembayaran</h2>
            <div class="mb-4">
                <select name="payment_method" required class="w-full border p-2 rounded focus:outline-none focus:border-[#c28455]">
                    @forelse($paymentMethods as $pay)
                        <option value="{{ $pay->name }}">{{ $pay->name }}</option>
                    @empty
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Tunai / Kasir">Tunai / Kasir</option>
                        <option value="QRIS">QRIS</option>
                    @endforelse
                </select>
            </div>
        </div>

        <!-- Ringkasan Pesanan (Dinamis dari Session Cart) -->
        <div class="bg-gray-50 p-6 rounded-lg shadow border">
            <h2 class="text-xl font-semibold mb-4 border-b pb-2">Ringkasan Pesanan</h2>
            
            @php 
                $cart = session()->get('cart', []);
                $subtotalItems = 0;
            @endphp

            @forelse($cart as $id => $item)
                @php 
                    $itemSubtotal = $item['price'] * $item['quantity'];
                    $subtotalItems += $itemSubtotal;
                @endphp
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                    <div>
                        <p class="font-bold">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-500">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $id }}">
                        <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] }}">
                    </div>
                    <p class="font-bold">Rp {{ number_format($itemSubtotal, 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Keranjang kosong.</p>
            @endforelse

            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between font-bold text-lg">
                    <p>Total Bayar</p>
                    <!-- Menampilkan total murni tanpa tambahan ongkir -->
                    <p class="text-[#c28455]">Rp {{ number_format($subtotalItems, 0, ',', '.') }}</p>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#1a1311] hover:bg-[#c28455] text-white font-bold py-3 rounded mt-6 transition">
                Buat Pesanan Sekarang
            </button>
        </div>
    </form>
</div>
@endsection