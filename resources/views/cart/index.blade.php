@extends('layouts.frontend')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">{{ session('error') }}</div>
    @endif

    @php $cart = session()->get('cart', []); @endphp

    @if(count($cart) > 0)
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Daftar Produk di Keranjang -->
        <div class="lg:w-2/3 bg-white shadow rounded-lg p-6">
            <table class="w-full text-left">
                <thead class="border-b">
                    <tr>
                        <th class="pb-4">Produk</th>
                        <th class="pb-4">Harga</th>
                        <th class="pb-4 text-center">Kuantitas</th>
                        <th class="pb-4 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $grandTotal = 0; $totalItems = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php 
                            $subtotal = $item['price'] * $item['quantity'];
                            $grandTotal += $subtotal;
                            $totalItems += $item['quantity'];
                        @endphp
                    <tr class="py-4">
                        <td class="py-4 flex items-center gap-4">
                            <div class="w-16 h-16 rounded bg-gray-50 flex items-center justify-center overflow-hidden border">
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/coffee-cup-1.png') }}" alt="{{ $item['name'] }}" class="w-3/4 object-contain">
                                @endif
                            </div>
                            <div>
                                <p class="font-bold">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-400">SKU: {{ $item['sku'] ?? '-' }}</p>
                                <form action="{{ route('cart.remove') }}" method="POST" class="mt-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="text-red-500 text-sm hover:underline"><i class="fas fa-trash-alt mr-1"></i>Hapus</button>
                                </form>
                            </div>
                        </td>
                        <td class="py-4">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="py-4 text-center">
                            <!-- Form Update Qty -->
                            <form action="{{ route('cart.update') }}" method="POST" class="inline-flex items-center border rounded">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="product_id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-12 text-center text-sm outline-none bg-transparent py-1" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td class="py-4 text-right font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Keranjang (Summary) -->
        <div class="lg:w-1/3">
            <div class="bg-gray-50 border shadow-sm rounded-lg p-6 sticky top-24">
                <h2 class="text-xl font-bold mb-4 border-b pb-4">Ringkasan Belanja</h2>
                
                <div class="flex justify-between mb-3 text-gray-600">
                    <span>Total Harga ({{ $totalItems }} barang)</span>
                    <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mb-4 text-gray-600">
                    <span>Diskon Promo</span>
                    <span class="text-green-500">- Rp 0</span>
                </div>

                <div class="border-t pt-4 mb-6 flex justify-between items-center">
                    <span class="font-bold text-lg">Total</span>
                    <span class="font-bold text-2xl text-[#c28455]">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="block text-center w-full bg-[#1a1311] hover:bg-[#c28455] text-white font-bold py-3 rounded transition">
                    Lanjut ke Checkout
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white p-12 rounded-lg shadow text-center">
        <div class="text-gray-400 text-5xl mb-4"><i class="fas fa-shopping-basket"></i></div>
        <p class="text-gray-600 text-lg mb-4">Keranjang belanja Anda masih kosong.</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-[#c28455] text-white px-6 py-3 rounded font-bold hover:bg-[#a66a40] transition">Mulai Belanja</a>
    </div>
    @endif
</div>
@endsection