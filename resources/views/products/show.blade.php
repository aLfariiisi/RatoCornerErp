@extends('layouts.frontend')
@section('title', $product->name)

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-500 mb-8">
        <a href="/" class="hover:text-[#c28455]">Home</a> &gt; 
        <a href="/products" class="hover:text-[#c28455]">Produk</a> &gt; 
        <span class="text-gray-800 font-semibold">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <!-- Gambar Produk -->
        <div class="bg-gray-50 rounded-xl p-8 flex items-center justify-center border h-96 overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
            @else
                <img src="{{ asset('images/coffee-cup-1.png') }}" alt="{{ $product->name }}" class="w-3/4 object-contain">
            @endif
        </div>

        <!-- Info Produk -->
        <div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
            <div class="flex items-center gap-4 mb-6">
                <span class="text-2xl font-bold text-[#c28455]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                
                <!-- Indikator Stok dari Sistem ERP -->
                @if($product->stock && $product->stock->quantity > 0)
                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded font-bold">Stok: Tersedia ({{ $product->stock->quantity }})</span>
                @else
                    <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded font-bold">Stok: Habis</span>
                @endif
            </div>

            <p class="text-gray-600 mb-8 leading-relaxed">
                {{ $product->description ?? 'Belum ada deskripsi untuk produk ini.' }}
            </p>

            <form action="/cart/add" method="POST" class="border-t pt-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div class="flex items-center gap-6 mb-6">
                    <label class="font-semibold text-gray-700">Kuantitas</label>
                    <div class="flex items-center border rounded">
                        <button type="button" class="px-4 py-2 text-gray-500 hover:bg-gray-100">-</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock->quantity ?? 1 }}" class="w-12 text-center focus:outline-none" readonly>
                        <button type="button" class="px-4 py-2 text-gray-500 hover:bg-gray-100">+</button>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-[#1a1311] hover:bg-[#c28455] text-white font-bold py-3 rounded transition">
                        <i class="fas fa-shopping-cart mr-2"></i> Tambah ke Keranjang
                    </button>
                    <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded transition">
                        <i class="fas fa-heart text-[#c28455]"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection