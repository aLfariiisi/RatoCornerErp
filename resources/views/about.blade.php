@extends('layouts.frontend')
@section('title', 'Tentang Kami')

@section('content')
<!-- Header Banner -->
<div class="bg-[#1a1311] py-16 text-center text-white">
    <h1 class="text-4xl font-serif font-bold italic mb-4">Tentang Rato Corner</h1>
    <p class="text-gray-400 max-w-2xl mx-auto px-4">Menyajikan lebih dari sekadar secangkir kopi. Kami menghadirkan pengalaman dan kehangatan di setiap tegukan.</p>
</div>

<!-- Konten Visi & Misi -->
<div class="max-w-5xl mx-auto py-16 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- Gambar Ilustrasi -->
        <div>
            <img src="{{ asset('images/hero-coffee.jpg') }}" alt="Tentang Rato Corner" class="rounded-lg shadow-lg object-cover h-96 w-full">
        </div>
        
        <!-- Teks Visi Misi -->
        <div>
            <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b-4 border-[#c28455] inline-block pb-2">Visi Kami</h2>
            <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                Menjadi kedai kopi dan penyedia biji kopi nusantara terkemuka yang diakui atas kualitas, pelayanan yang hangat, serta kontribusi positif terhadap komunitas pecinta kopi di seluruh Indonesia.
            </p>

            <h2 class="text-3xl font-bold mb-6 text-gray-800 border-b-4 border-[#c28455] inline-block pb-2">Misi Kami</h2>
            <ul class="space-y-4 text-gray-600 text-lg">
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#c28455] mt-1"></i>
                    <span>Menyajikan kopi dengan kualitas terbaik dari petani lokal pilihan.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#c28455] mt-1"></i>
                    <span>Memberikan pelayanan pelanggan yang ramah, cepat, dan responsif.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#c28455] mt-1"></i>
                    <span>Menciptakan suasana kedai (corner) yang nyaman bagi setiap pengunjung.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-[#c28455] mt-1"></i>
                    <span>Berinovasi secara berkelanjutan dalam menghadirkan menu dan layanan baru.</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection