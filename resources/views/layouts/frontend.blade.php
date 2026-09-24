<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title Dinamis (Nama Halaman | Nama Website ERP) -->
    <title>@yield('title', 'Beranda') | {{ $setting->site_name ?? 'Rato Corner' }}</title>

    <!-- Favicon Dinamis -->
    @if(isset($setting) && $setting->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $setting->favicon) }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/rato-corner-logo.jpeg') }}">
    @endif

    <!-- Gunakan Tailwind CSS via CDN untuk kemudahan, atau kompilasi via Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-[#fdfaf5] text-gray-800">

    <!-- Navbar -->
    <header class="bg-[#1a1311] text-white py-4 px-8 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <!-- Menampilkan Logo dari Panel Admin Settings -->
            <a href="/" class="flex items-center gap-3">
                @if(isset($setting) && $setting->logo)
                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->site_name ?? 'Logo' }}" class="h-12 bg-white p-1 rounded object-contain">
                @else
                    <!-- Fallback jika logo belum diupload di admin -->
                    <img src="{{ asset('images/rato-corner-logo.jpeg') }}" alt="Default Logo" class="h-12 bg-white p-1 rounded">
                @endif
            </a>
            <div class="hidden md:block">
                <p class="text-sm text-yellow-500">Booking Table</p>
                <p class="font-bold">{{ $setting->phone ?? '+62 800-1234-435' }}</p>
            </div>
        </div>

        <nav class="hidden md:flex gap-6 text-sm font-semibold">
            <a href="/" class="hover:text-yellow-500 transition">Home</a>
            <a href="/about" class="hover:text-yellow-500 transition">About Us</a>
            <a href="/products" class="hover:text-yellow-500 transition">Product</a>
            <a href="/contact" class="hover:text-yellow-500 transition">Contact Us</a>
        </nav>

        <div class="flex items-center gap-4">
            <button class="hover:text-yellow-500"><i class="fas fa-search"></i></button>
            
            <!-- Keranjang Belanja Dinamis & Aman dari Error Session -->
            @php
                $cart = session()->get('cart', []);
                $cartTotalCount = 0;
                $cartTotalPrice = 0;
                
                if (is_array($cart)) {
                    foreach($cart as $item) {
                        if (is_array($item) && isset($item['price']) && isset($item['quantity'])) {
                            $cartTotalCount += (int) $item['quantity'];
                            $cartTotalPrice += (float) $item['price'] * (int) $item['quantity'];
                        }
                    }
                }
            @endphp
            
            <a href="{{ route('cart.index') }}" class="flex items-center gap-2 hover:text-yellow-500 relative">
                <div class="relative">
                    <i class="fas fa-shopping-basket text-lg"></i>
                    @if($cartTotalCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full font-bold">
                            {{ $cartTotalCount }}
                        </span>
                    @endif
                </div>
                <span class="text-sm font-semibold">Rp {{ number_format($cartTotalPrice, 0, ',', '.') }}</span>
            </a>
            
            @auth
                <!-- Jika yang login adalah Admin, tampilkan tombol ke Backend -->
                @role('admin')
                    <a href="{{ route('admin.dashboard') }}" class="bg-[#c28455] text-white px-4 py-1.5 rounded text-sm font-bold hover:bg-[#a66a40] transition">
                        <i class="fas fa-solar-panel mr-1"></i> Panel ERP
                    </a>
                @endrole
                
                <a href="{{ route('dashboard') }}" class="text-sm hover:text-yellow-500">Akun Saya</a>
            @else
                <a href="/login" class="text-sm hover:text-yellow-500">Login</a>
            @endauth
        </div>
    </header>

    <!-- Konten Halaman -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Singkat -->
    <footer class="bg-[#1a1311] text-gray-400 py-10 text-center text-sm">
        <p>&copy; {{ date('Y') }} {{ $setting->site_name ?? 'Rato Corner' }}. All Rights Reserved.</p>
        <div class="flex justify-center gap-4 mt-4">
            <a href="/faq" class="hover:text-white">FAQ</a>
            <a href="/terms" class="hover:text-white">Syarat & Ketentuan</a>
            <a href="/privacy" class="hover:text-white">Kebijakan Privasi</a>
        </div>
    </footer>

</body>
</html>