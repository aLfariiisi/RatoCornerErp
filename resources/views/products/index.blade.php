@extends('layouts.frontend')
@section('title', 'Katalog Produk')

@section('content')
<!-- Header Halaman -->
<div class="bg-[#1a1311] text-white py-12 text-center">
    <h1 class="text-4xl font-serif font-bold italic mb-2">Our Menu & Products</h1>
    <p class="text-gray-400">Pilih dan nikmati seduhan kopi terbaik dari Rato Corner.</p>
</div>

<div class="max-w-6xl mx-auto py-12 px-4">
    <!-- Filter Kategori Dinamis dari Database -->
    <div class="flex justify-center flex-wrap gap-3 mb-10 border-b pb-4">
        <!-- Tombol Semua Kategori -->
        <a href="{{ route('products.index') }}" 
           class="{{ request('category') == null ? 'text-[#c28455] font-bold border-b-2 border-[#c28455]' : 'text-gray-500 hover:text-[#c28455]' }} pb-2 transition">
            Semua
        </a>

        <!-- Looping Kategori dari Database -->
        @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->id]) }}" 
               class="{{ request('category') == $cat->id ? 'text-[#c28455] font-bold border-b-2 border-[#c28455]' : 'text-gray-500 hover:text-[#c28455]' }} pb-2 transition">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Grid Produk (Di-looping dari ProductController/Closure backend) -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
        
        @forelse ($products as $product)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group">
            <a href="{{ route('products.show', $product->id) }}" class="relative bg-gray-50 h-56 flex items-center justify-center p-4 block overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <img src="{{ asset('images/coffee-cup-1.png') }}" alt="{{ $product->name }}" class="h-full object-contain group-hover:scale-105 transition duration-300">
                @endif
                <span class="absolute top-2 right-2 bg-green-100 text-green-700 text-xs px-2 py-1 rounded font-bold">SKU: {{ $product->sku }}</span>
            </a>
            
            <div class="p-5">
                <div class="mb-2">
                    <span class="text-xs uppercase tracking-wider text-[#c28455] font-semibold">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>
                </div>
                <a href="{{ route('products.show', $product->id) }}">
                    <h3 class="font-bold text-lg text-gray-800 mb-1 hover:text-[#c28455] transition">{{ $product->name }}</h3>
                </a>
                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $product->description ?? 'Belum ada deskripsi produk.' }}</p>
                
                <div class="flex justify-between items-center mt-4">
                    <p class="font-bold text-xl text-[#c28455]">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    
                    <!-- Form Add to Cart -->
                    <form action="/cart/add" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="bg-[#1a1311] hover:bg-[#c28455] text-white h-10 w-10 rounded-full flex items-center justify-center transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="text-gray-400 text-5xl mb-4"><i class="fas fa-box-open"></i></div>
            <p class="text-gray-500 text-lg">Belum ada produk dalam kategori ini.</p>
            <p class="text-sm text-gray-400 mt-1">Silakan pilih kategori lain atau tambahkan produk baru melalui panel admin ERP.</p>
        </div>
        @endforelse

    </div>

    <!-- Pagination Database -->
    <div class="mt-12 flex justify-center">
        {{ $products->links() }}
    </div>
</div>
@endsection