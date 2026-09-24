@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Laporan Keuangan (Laba / Rugi)</h1>
    <p class="text-sm text-gray-500">Ringkasan arus kas pemasukan, pengeluaran operasional, dan laba bersih bisnis.</p>
</div>

<!-- Kartu Statistik Utama -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100">
        <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-bold text-emerald-600">Rp {{ number_format($income, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100">
        <p class="text-sm text-gray-500 mb-1">Total Pengeluaran</p>
        <h3 class="text-2xl font-bold text-red-500">Rp {{ number_format($expenses, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100">
        <p class="text-sm text-gray-500 mb-1">Laba Bersih (Net Profit)</p>
        <h3 class="text-2xl font-bold text-primary">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
    </div>
</div>

<!-- Form Input Pengeluaran Baru -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 mb-8">
    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2"><i class="fa-solid fa-money-bill-transfer mr-2 text-red-500"></i>Catat Pengeluaran Operasional</h2>
    
    <form action="{{ route('admin.expenses.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
        @csrf
        <div class="flex-1 w-full">
            <label class="block text-sm font-medium mb-1 text-gray-700">Keterangan Transaksi</label>
            <input type="text" name="description" required placeholder="Contoh: Belanja biji kopi, Bayar listrik, dll..." class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-[#c28455] focus:ring-1 focus:ring-[#c28455]">
        </div>
        <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium mb-1 text-gray-700">Nominal (Rp)</label>
            <input type="number" name="amount" min="1" required placeholder="Contoh: 150000" class="w-full border border-gray-300 p-2.5 rounded-lg focus:outline-none focus:border-[#c28455] focus:ring-1 focus:ring-[#c28455]">
        </div>
        <button type="submit" class="w-full md:w-auto bg-[#c28455] hover:bg-[#a86e43] text-white font-bold py-2.5 px-6 rounded-lg transition h-[46px]">
            Simpan Data
        </button>
    </form>
    </form>
</div>

<!-- Tabel Riwayat Arus Keuangan Terpadu (Pemasukan & Pengeluaran) -->
<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Arus Keuangan (Pemasukan & Pengeluaran)</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Keterangan Transaksi</th>
                    <th class="py-3 px-4 text-right">Pemasukan (Debit)</th>
                    <th class="py-3 px-4 text-right">Pengeluaran (Kredit)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-gray-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($trx['date'])->format('d M Y') }}
                    </td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $trx['description'] }}</td>
                    <td class="py-3 px-4 text-right font-semibold text-emerald-600">
                        @if($trx['income'] > 0)
                            Rp {{ number_format($trx['income'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="py-3 px-4 text-right font-semibold text-red-500">
                        @if($trx['expense'] > 0)
                            Rp {{ number_format($trx['expense'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-400">Belum ada riwayat transaksi keuangan yang tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection