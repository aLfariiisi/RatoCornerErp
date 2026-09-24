@extends('layouts.frontend')
@section('title', 'Syarat dan Ketentuan')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto bg-white p-10 rounded-xl shadow-sm border">
        <h1 class="text-4xl font-serif font-bold italic text-gray-800 mb-6 border-b pb-4">Syarat dan Ketentuan</h1>
        
        <div class="prose max-w-none text-gray-600 space-y-6">
            <p>Pembaruan Terakhir: 22 September 2026</p>
            
            <p>Selamat datang di website Rato Corner. Dengan mengakses dan menggunakan website ini, Anda setuju untuk terikat oleh Syarat dan Ketentuan berikut. Jika Anda tidak setuju dengan ketentuan ini, mohon untuk tidak menggunakan layanan kami.</p>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-2">1. Penggunaan Layanan</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li>Pengguna harus berusia minimal 18 tahun atau memiliki izin dari orang tua/wali untuk melakukan transaksi.</li>
                <li>Pengguna setuju untuk memberikan informasi yang akurat dan lengkap saat mendaftar akun dan melakukan *checkout*.</li>
                <li>Dilarang menggunakan website ini untuk tindakan penipuan, spam, atau aktivitas ilegal lainnya.</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-2">2. Pemesanan dan Pembayaran</h3>
            <ul class="list-disc pl-5 space-y-2">
                <li>Semua pesanan tunduk pada ketersediaan stok yang dikelola dalam sistem ERP kami.</li>
                <li>Harga dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya, namun harga yang sudah di-*checkout* tidak akan berubah.</li>
                <li>Pembayaran harus diselesaikan sesuai dengan batas waktu yang ditentukan. Pesanan akan otomatis dibatalkan (pending ke cancelled) jika melewati batas waktu.</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-2">3. Kebijakan Pengembalian (Return & Exchange)</h3>
            <p>Jika terdapat kesalahan pesanan atau barang yang cacat, Anda berhak mengajukan pengembalian melalui dashboard pengguna maksimal 2x24 jam setelah barang diterima. Tim admin kami akan meninjau keluhan Anda melalui sistem Return/Exchange kami.</p>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-2">4. Hak Kekayaan Intelektual</h3>
            <p>Semua konten yang ada di website ini, termasuk logo, gambar, dan teks, adalah milik Rato Corner dan dilindungi oleh undang-undang hak cipta. Penggunaan konten tanpa izin tertulis dilarang keras.</p>
        </div>
    </div>
</div>
@endsection