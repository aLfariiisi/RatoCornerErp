@extends('layouts.frontend')
@section('title', 'Testimoni Pelanggan')

@section('content')
<div class="bg-[#fdfaf5] py-16">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl font-serif font-bold italic text-gray-800 mb-4">Apa Kata Pelanggan Kami?</h1>
        <p class="text-gray-500 mb-12 max-w-2xl mx-auto">Kami selalu berusaha memberikan pengalaman terbaik. Berikut adalah beberapa pengalaman berharga dari pelanggan setia Rato Corner.</p>

        <!-- Grid Testimoni -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            
            <!-- Card Testimoni 1 -->
            <div class="bg-white p-8 rounded-xl shadow border border-gray-100 relative">
                <i class="fas fa-quote-left text-4xl text-gray-100 absolute top-4 right-4"></i>
                <div class="text-yellow-400 text-sm mb-4">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6 italic">"Kopinya benar-benar enak dan fresh! Pengiriman sangat cepat dan sistem tracking pesanannya sangat membantu. Saya pasti akan langganan terus."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#c28455] text-white rounded-full flex items-center justify-center font-bold text-xl">A</div>
                    <div>
                        <h4 class="font-bold text-gray-800">Andi Saputra</h4>
                        <p class="text-xs text-gray-500">Pelanggan Setia</p>
                    </div>
                </div>
            </div>

            <!-- Card Testimoni 2 -->
            <div class="bg-white p-8 rounded-xl shadow border border-gray-100 relative">
                <i class="fas fa-quote-left text-4xl text-gray-100 absolute top-4 right-4"></i>
                <div class="text-yellow-400 text-sm mb-4">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6 italic">"Pernah mengajukan keluhan karena bungkus sobek saat pengiriman, admin ERP Rato Corner langsung responsif dan mengirimkan produk pengganti besoknya."</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-800 text-white rounded-full flex items-center justify-center font-bold text-xl">B</div>
                    <div>
                        <h4 class="font-bold text-gray-800">Budi Santoso</h4>
                        <p class="text-xs text-gray-500">Penikmat Espresso</p>
                    </div>
                </div>
            </div>

            <!-- Card Testimoni 3 -->
            <div class="bg-white p-8 rounded-xl shadow border border-gray-100 relative">
                <i class="fas fa-quote-left text-4xl text-gray-100 absolute top-4 right-4"></i>
                <div class="text-yellow-400 text-sm mb-4">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                </div>
                <p class="text-gray-600 mb-6 italic">"Sangat mudah untuk checkout via website ini. UI-nya nyaman, dan opsi pembayarannya lengkap banget dari transfer sampai COD. Mantap!"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#c28455] text-white rounded-full flex items-center justify-center font-bold text-xl">C</div>
                    <div>
                        <h4 class="font-bold text-gray-800">Citra Lestari</h4>
                        <p class="text-xs text-gray-500">Pecinta Kopi Susu</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection