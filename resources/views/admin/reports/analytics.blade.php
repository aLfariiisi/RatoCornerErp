@extends('layouts.admin')

@section('title', 'Laporan Analitik & Statistik')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Analitik & Statistik Bisnis</h1>
        <p class="text-sm text-gray-500">Grafik tren pendapatan, pengeluaran, dan laba bersih toko Anda.</p>
    </div>
    <div>
        <span class="bg-orange-100 text-[#c28455] font-semibold text-xs px-3 py-1.5 rounded-full">
            Tahun {{ date('Y') }}
        </span>
    </div>
</div>

<!-- 4 Kartu Statistik Utama -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-orange-100">
        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Pendapatan</p>
        <h3 class="text-xl font-bold text-emerald-600">Rp {{ number_format($totalSales ?? 0, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-orange-100">
        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Pengeluaran</p>
        <h3 class="text-xl font-bold text-red-500">Rp {{ number_format($expenses ?? 0, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-orange-100">
        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Laba Bersih</p>
        <h3 class="text-xl font-bold text-[#c28455]">Rp {{ number_format($netProfit ?? 0, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-orange-100">
        <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Pesanan Valid</p>
        <h3 class="text-xl font-bold text-gray-800">{{ $totalOrders ?? 0 }} <span class="text-xs font-normal text-gray-500">Order</span></h3>
    </div>
</div>

<!-- Bagian Grafik (Pendapatan, Pengeluaran, Laba Bersih) & Status Pesanan -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100 lg:col-span-2">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Grafik Keuangan Bulanan</h3>
        </div>
        <div class="relative h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Grafik Donat: Distribusi Status Pesanan -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Distribusi Status Pesanan</h3>
        <div class="relative h-80 flex items-center justify-center">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- Tabel Produk Terlaris -->
<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">5 Produk Terlaris</h3>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-4">Nama Produk</th>
                <th class="py-3 px-4 text-center">Total Terjual</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($topProducts ?? [] as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-3 px-4 font-semibold text-gray-800">{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                <td class="py-3 px-4 text-center font-medium text-primary">{{ $item->total_sold }} pcs</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="py-6 text-center text-gray-400">Belum ada data produk terlaris.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Include Chart.js Script CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Inisialisasi Grafik Keuangan (Pendapatan, Pengeluaran, Laba Bersih)
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: @json($salesMonths),
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: @json($salesData),
                    borderColor: '#c28455', // Oranye
                    backgroundColor: 'rgba(194, 132, 85, 0.05)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: false,
                    pointRadius: 3
                },
                {
                    label: 'Pengeluaran (Rp)',
                    data: @json($expenseData),
                    borderColor: '#ef4444', // Merah (Pengeluaran)
                    backgroundColor: 'rgba(239, 68, 68, 0.05)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: false,
                    pointRadius: 3
                },
                {
                    label: 'Laba Bersih (Rp)',
                    data: @json($profitData),
                    borderColor: '#10b981', // Hijau (Profit)
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    borderWidth: 3,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { boxWidth: 12, font: { size: 11 } }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Inisialisasi Grafik Sebaran Status Pesanan (Doughnut Chart)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: @json($statusLabels),
            datasets: [{
                data: @json($statusCounts),
                backgroundColor: ['#f59e0b', '#3b82f6', '#8b5cf6', '#10b981', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, font: { size: 11 } }
                }
            }
        }
    });
</script>
@endsection