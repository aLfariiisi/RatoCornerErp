@extends('layouts.frontend')
@section('title', 'Wishlist Saya')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-8">Wishlist Saya</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-700 p-4 rounded mb-6">{{ session('info') }}</div>
    @endif

    @if(isset($wishlists) && count($wishlists) > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($wishlists as $item)
        <div class="bg-white rounded-lg shadow border p-4 flex flex-col justify-between">
            <div>
                <a href="{{ route('products.show', $item->product->id) }}">
                    <img src="{{ asset('images/coffee-cup-1.png') }}" alt="{{ $item->product->name }}" class="w-full h-40 object-contain mb-4 rounded bg-gray-50">
                </a>
                <p class="text-xs text-gray-400 mb-1">{{ $item->product->category->name ?? 'Kopi' }}</p>
                <a href="{{ route('products.show', $item->product->id) }}">
                    <h3 class="font-bold text-gray-800 hover:text-[#c28455] transition truncate">{{ $item->product->name }}</h3>
                </a>
                <p class="font-bold text-[#c28455] mt-2">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
            </div>

            <div class="mt-4 pt-4 border-t flex items-center justify-between gap-2">
                <!-- Tombol Masuk Keranjang -->
                <form action="{{ route('cart.add') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="w-full bg-[#1a1311] hover:bg-[#c28455] text-white text-xs py-2 px-3 rounded transition text-center">
                        + Keranjang
                    </button>
                </form>

                <!-- Tombol Hapus dari Wishlist -->
                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded transition" title="Hapus dari Wishlist">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white p-12 rounded-lg shadow text-center">
        <div class="text-gray-400 text-5xl mb-4"><i class="fas fa-heart-broken"></i></div>
        <p class="text-gray-600 text-lg mb-4">Wishlist Anda masih kosong.</p>
        <a href="{{ route('products.index') }}" class="inline-block bg-[#c28455] text-white px-6 py-3 rounded font-bold hover:bg-[#a66a40] transition">Jelajahi Produk</a>
    </div>
    @endif
</div>
@endsection