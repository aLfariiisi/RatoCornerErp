<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barista Coffee Shop')</title>
    
    <!-- Memuat CSS dari folder public/frontend/css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/importer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome/css/all.css') }}">
    
    @stack('styles')
</head>
<body>

    <!-- Header / Navbar -->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="{{ route('home') }}">Barista Coffee</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                        <!-- Tambahkan menu navigasi customer lainnya di sini -->
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Konten Utama -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4">
        <div class="container">
            <p>&copy; {{ date('Y') }} Barista Coffee Shop. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- JS Scripts -->
    @stack('scripts')
</body>
</html>