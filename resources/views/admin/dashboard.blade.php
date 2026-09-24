@extends('layouts.admin')

@section('title', 'Dashboard Administrator')

@section('content')
<!-- Header Sambutan -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Hi, {{ auth()->user()->name }}!</h1>
    <p class="text-sm text-gray-500">Ringkasan performa keuangan dan pemantauan sistem ERP Rato Corner.</p>
</div>

<!-- Grid Kartu Statistik Utama -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <!-- Total Pengeluaran -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 flex flex-col justify-between">
        <div>
            <h3 class="text-xs font-bold uppercase text-gray-500 tracking-wider mb-1">Total Pengeluaran</h3>
            <p class="text-xs text-gray-400 mb-4">Akumulasi biaya ekspedisi & operasional toko...</p>
        </div>
        <div class="my-2">
            <h2 class="text-2xl font-bold text-red-500">Rp {{ number_format($expenses ?? 0, 0, ',', '.') }}</h2>
            <span class="text-xs text-gray-400">Tercatat dari pengeluaran valid</span>
        </div>
    </div>

    <!-- Net Profit Margin -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 flex flex-col justify-between">
        <div>
            <h3 class="text-xs font-bold uppercase text-gray-500 tracking-wider mb-1">Net Profit Margin</h3>
            <p class="text-xs text-gray-400 mb-4">Rasio keuntungan bersih terhadap total pendapatan...</p>
        </div>
        <div class="flex items-center justify-center my-2">
            <div class="relative w-28 h-28 rounded-full border-8 border-blue-50 flex items-center justify-center border-t-blue-500 shadow-inner">
                <span class="text-2xl font-bold text-gray-800">{{ $netProfitMargin }}%</span>
            </div>
        </div>
    </div>

    <!-- Account / Balance Card (Ringkasan Keuangan Utama) -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 flex flex-col justify-between bg-gradient-to-br from-white to-orange-50/30">
        <div>
            <div class="flex justify-between items-start mb-2">
                <span class="text-xs font-bold uppercase text-gray-500 tracking-wider">Laba Bersih Toko</span>
                <span class="bg-[#c28455] text-white text-xs font-bold px-2.5 py-0.5 rounded">ERP</span>
            </div>
            <h2 class="text-2xl font-extrabold text-emerald-600 mb-1">Rp {{ number_format($netProfit ?? 0, 0, ',', '.') }}</h2>
            <p class="text-xs text-gray-400 mb-4">STATUS KEUANGAN AKTIF</p>
            <div class="flex gap-4 text-sm font-mono tracking-widest text-gray-600 mb-6">
                <span>RATO</span><span>CORNER</span><span>ERP</span><span>2026</span>
            </div>
        </div>
        <div class="flex justify-between text-xs text-gray-500 border-t pt-3">
            <div>
                <span class="block text-gray-400">ADMINISTRATOR</span>
                <span class="font-semibold text-gray-700">{{ auth()->user()->name }}</span>
            </div>
            <div>
                <span class="block text-gray-400">TOTAL ORDER</span>
                <span class="font-semibold text-gray-700">{{ $totalOrders }} Valid</span>
            </div>
        </div>
    </div>

</div>

<!-- Grid Baris Kedua: Metrik Keuangan -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Quick Overview / Status Sistem Dinamis -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 md:col-span-2 flex flex-col justify-between">
        <div>
            <h3 class="text-xs font-bold uppercase text-gray-500 tracking-wider mb-1">Kesehatan Finansial Bisnis</h3>
            <div class="flex items-baseline gap-3 mb-2">
                <span class="text-3xl font-extrabold {{ $netProfit > 0 ? 'text-emerald-600' : ($netProfit == 0 ? 'text-amber-500' : 'text-red-500') }}">
                    @if($netProfit > 0)
                        Sehat & Profitable
                    @elseif($netProfit == 0)
                        Imbang (Break Even)
                    @else
                        Defisit (Perlu Evaluasi)
                    @endif
                </span>
            </div>
            <p class="text-xs text-gray-400 mb-4">Indikator Profitabilitas: {{ max($netProfitMargin, 0) }}% dari total pendapatan menjadi laba bersih.</p>
            <p class="text-xs text-gray-600 leading-relaxed mb-4">
                Sistem ERP mencatat seluruh transaksi penjualan, rincian produk, dan ongkos kirim ekspedisi secara otomatis saat status pesanan diubah menjadi <em>shipped</em> atau <em>completed</em>.
            </p>
        </div>
        <!-- Progress Bar Dinamis Berdasarkan Data Database -->
        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
            <div class="bg-[#c28455] h-full transition-all duration-500" style="width: {{ min(max($netProfitMargin, 5), 100) }}%"></div>
        </div>
    </div>

    <!-- Total Income -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 flex flex-col justify-between">
        <div>
            <h3 class="text-xs font-bold uppercase text-gray-500 tracking-wider mb-1">Total Pendapatan</h3>
            <h2 class="text-xl font-bold text-gray-800 mb-1">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</h2>
            <p class="text-xs text-emerald-600 font-semibold mb-4">Akumulasi penjualan valid</p>
        </div>
        <div class="flex items-end gap-1 h-12">
            <!-- Visualisasi bar mini -->
            <div class="w-1/6 bg-orange-300 h-4 rounded-t"></div>
            <div class="w-1/6 bg-orange-400 h-8 rounded-t"></div>
            <div class="w-1/6 bg-orange-500 h-6 rounded-t"></div>
            <div class="w-1/6 bg-[#c28455] h-12 rounded-t"></div>
            <div class="w-1/6 bg-orange-400 h-9 rounded-t"></div>
            <div class="w-1/6 bg-[#1a1311] h-11 rounded-t"></div>
        </div>
    </div>

</div>
@endsection