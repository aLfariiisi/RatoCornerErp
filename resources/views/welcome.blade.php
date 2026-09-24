@extends('layouts.frontend')
@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[500px] flex items-center justify-center text-center" style="background-image: url('{{ asset('images/hero-coffee.jpg') }}');">
        <!-- Overlay gelap -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        
        <div class="relative z-10 text-white max-w-2xl px-4">
            <p class="text-yellow-500 tracking-widest text-sm font-bold uppercase mb-2">Best Coffee Shop</p>
            <h1 class="text-5xl font-serif font-bold italic mb-6">Coffee from the Best Sunny Plantations</h1>
            <a href="/products" class="bg-[#c28455] hover:bg-[#a66a40] text-white px-8 py-3 rounded-full font-semibold transition">Shop Now</a>
        </div>
    </section>

    <!-- Best Seller Section (Dinamis dari Database) -->
    <section class="py-16 px-8 max-w-6xl mx-auto text-center">
        <h2 class="text-4xl font-serif font-bold italic text-gray-800 mb-2">Best Seller Product This Week!</h2>
        <p class="text-gray-500 mb-12 max-w-xl mx-auto">Nikmati pilihan kopi terbaik kami yang paling banyak diminati minggu ini, diseduh dari biji kopi pilihan kualitas premium.</p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @forelse ($products as $product)
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-left">
                <a href="{{ route('products.show', $product->id) }}" class="block overflow-hidden h-48 mb-4 bg-gray-50 rounded flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/coffee-cup-1.png') }}" alt="{{ $product->name }}" class="h-full object-contain">
                    @endif
                </a>
                <div class="text-yellow-400 text-xs mb-1">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <a href="{{ route('products.show', $product->id) }}">
                    <h3 class="font-bold text-lg text-gray-800 hover:text-[#c28455] transition truncate">{{ $product->name }}</h3>
                </a>
                <div class="flex justify-between items-end mt-3">
                    <p class="font-bold text-lg text-[#c28455]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="bg-[#1a1311] hover:bg-[#c28455] text-white text-xs px-3 py-2 rounded transition">Detail</a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-8 text-gray-500">
                <p>Belum ada produk unggulan yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </section>
@endsection