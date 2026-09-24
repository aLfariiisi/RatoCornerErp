@extends('layouts.frontend')
@section('title', 'Blog & Berita')

@section('content')
<div class="bg-[#fdfaf5] py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-serif font-bold italic text-gray-800 mb-4">Blog & Artikel</h1>
            <p class="text-gray-500">Temukan cerita menarik seputar dunia kopi, tips menyeduh, dan kabar terbaru dari kami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Artikel 1 -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition group">
                <div class="h-48 overflow-hidden bg-gray-200">
                    <img src="{{ asset('images/hero-coffee.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <p class="text-[#c28455] text-xs font-bold uppercase mb-2">Edukasi Kopi</p>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 hover:text-[#c28455] transition cursor-pointer">Perbedaan Arabika dan Robusta yang Wajib Anda Tahu</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">Bagi penikmat kopi pemula, membedakan jenis biji kopi bisa jadi membingungkan. Mari kita bahas perbedaan mendasarnya...</p>
                    <a href="#" class="font-semibold text-sm text-[#1a1311] hover:text-[#c28455]">Baca Selengkapnya &rarr;</a>
                </div>
            </div>

            <!-- Artikel 2 -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition group">
                <div class="h-48 overflow-hidden bg-gray-200">
                    <img src="{{ asset('images/hero-coffee.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <p class="text-[#c28455] text-xs font-bold uppercase mb-2">Tips & Trik</p>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 hover:text-[#c28455] transition cursor-pointer">Cara Membuat Kopi Susu Gula Aren ala Kafe di Rumah</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">Tidak perlu peralatan mahal, Anda bisa menyeduh kopi susu gula aren yang creamy dan enak hanya dengan alat sederhana...</p>
                    <a href="#" class="font-semibold text-sm text-[#1a1311] hover:text-[#c28455]">Baca Selengkapnya &rarr;</a>
                </div>
            </div>

            <!-- Artikel 3 -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition group">
                <div class="h-48 overflow-hidden bg-gray-200">
                    <img src="{{ asset('images/hero-coffee.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <p class="text-[#c28455] text-xs font-bold uppercase mb-2">Berita Kami</p>
                    <h3 class="text-xl font-bold text-gray-800 mb-3 hover:text-[#c28455] transition cursor-pointer">Rato Corner Kini Hadir dengan Menu Snack Baru!</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">Menemani waktu ngopi Anda, kami meluncurkan berbagai pilihan pastry dan snack gurih yang cocok disandingkan dengan kopi favorit Anda...</p>
                    <a href="#" class="font-semibold text-sm text-[#1a1311] hover:text-[#c28455]">Baca Selengkapnya &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection