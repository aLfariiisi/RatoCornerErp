<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin ERP - @yield('title', 'Dashboard')</title>

    <!-- Favicon Dinamis Aman -->
    @php
        try {
            $globalSetting = \App\Models\Setting::first();
        } catch (\Exception $e) {
            $globalSetting = null;
        }
    @endphp

    @if($globalSetting && $globalSetting->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $globalSetting->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/rato-corner-logo.jpeg') }}">
    @endif

    <!-- Google Fonts: Outfit & Yesteryear -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Yesteryear&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN untuk utility UI yang cepat & rapi ala Dashboard Modern -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#c1753d',
                        secondary: '#f7ebe5',
                        darkcustom: '#222222',
                    },
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif'],
                        yesteryear: ['Yesteryear', 'cursive'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f7ebe5; color: #222222; }
        h1, h2, h3, h4 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-orange-100 flex flex-col z-20 shadow-sm">
        <div class="h-16 flex items-center px-6 border-b border-orange-100">
            <span class="text-2xl font-bold font-yesteryear text-primary">ERP System</span>
        </div>
        <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-chart-pie w-5"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-box w-5"></i> Produk
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-tags w-5"></i> Kategori
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-shopping-cart w-5"></i> Pesanan (ERP)
            </a>
            <a href="{{ route('admin.stocks.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-warehouse w-5"></i> Manajemen Stok
            </a>
            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-wallet w-5"></i> Pembayaran
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-users w-5"></i> Pelanggan
            </a>
            <a href="{{ route('admin.crm.customers.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-headset w-5"></i> CRM & Leads
            </a>
            <a href="{{ route('admin.returns.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-rotate-left w-5"></i> Return & Exchange
            </a>
            <a href="{{ route('admin.reports.analytics') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-chart-line w-5"></i> Analitik & Statistik
            </a>
            <a href="{{ route('admin.reports.financials') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-file-invoice-dollar w-5"></i> Keuangan (Laba/Rugi)
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-primary transition">
                <i class="fa-solid fa-gear w-5"></i> Pengaturan
            </a>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-orange-100 flex items-center justify-between px-8 z-10">
            <div class="flex items-center w-96 bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5">
                <i class="fa-solid fa-search text-gray-400 mr-2"></i>
                <input type="text" placeholder="Search for anything..." class="bg-transparent border-none focus:outline-none text-sm w-full">
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Administrator' }}</span>
                <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Dynamic Content Section -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded shadow-sm" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>