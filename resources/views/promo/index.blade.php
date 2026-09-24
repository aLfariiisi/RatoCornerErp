@extends('layouts.frontend')
@section('title', 'Promo & Diskon')

@section('content')
<div class="bg-[#1a1311] py-16 text-center text-white">
    <h1 class="text-4xl font-serif font-bold italic mb-4">Promo Spesial Rato Corner</h1>
    <p class="text-gray-400">Nikmati penawaran terbaik dan hemat lebih banyak untuk kopi favorit Anda.</p>
</div>

<div class="max-w-5xl mx-auto py-16 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Kupon Promo 1 -->
        <div class="bg-white border-2 border-dashed border-[#c28455] rounded-xl flex items-center overflow-hidden shadow-sm">
            <div class="bg-[#c28455] text-white p-6 h-full flex flex-col justify-center items-center w-1/3">
                <span class="text-3xl font-bold">20%</span>
                <span class="text-sm">OFF</span>
            </div>
            <div class="p-6 w-2/3 relative">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Diskon Pengguna Baru</h3>
                <p class="text-sm text-gray-600 mb-4">Gunakan kode voucher ini pada pesanan pertama Anda. Maksimal potongan Rp 15.000.</p>
                <div class="flex items-center justify-between">
                    <span class="font-mono bg-gray-100 px-3 py-1 text-gray-800 rounded border font-bold">NEWUSER20</span>
                    <button class="text-[#c28455] hover:underline text-sm font-bold">Salin Kode</button>
                </div>
            </div>
        </div>

        <!-- Kupon Promo 2 -->
        <div class="bg-white border-2 border-dashed border-[#c28455] rounded-xl flex items-center overflow-hidden shadow-sm">
            <div class="bg-gray-800 text-white p-6 h-full flex flex-col justify-center items-center w-1/3">
                <span class="text-3xl font-bold">FREE</span>
                <span class="text-sm">ONGKIR</span>
            </div>
            <div class="p-6 w-2/3 relative">
                <h3 class="text-xl font-bold text-gray-800 mb-2">Gratis Ongkir Jabodetabek</h3>
                <p class="text-sm text-gray-600 mb-4">Belanja minimal Rp 100.000 dapatkan gratis ongkir otomatis tanpa kode voucher.</p>
                <div class="flex items-center justify-between">
                    <span class="font-mono bg-gray-100 px-3 py-1 text-gray-800 rounded border font-bold">OTOMATIS</span>
                    <a href="/products" class="text-gray-800 hover:underline text-sm font-bold">Belanja Sekarang &rarr;</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection