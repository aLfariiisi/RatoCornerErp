@extends('layouts.frontend')
@section('title', 'Kebijakan Privasi')

@section('content')
<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto bg-white p-10 rounded-xl shadow-sm border">
        <h1 class="text-4xl font-serif font-bold italic text-gray-800 mb-6 border-b pb-4">Kebijakan Privasi</h1>
        
        <div class="prose max-w-none text-gray-600 space-y-6">
            <p>Pembaruan Terakhir: 22 September 2026</p>
            
            <p>Rato Corner menghargai privasi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda saat menggunakan layanan e-commerce kami.</p>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-2">1. Informasi yang Kami Kumpulkan</h3>
            <p>Kami mengumpulkan data dari Anda saat Anda mendaftar, melakukan transaksi, atau mengisi form kontak kami. Data tersebut meliputi:</p>
            <ul class="list-disc pl-5 space-y-2">
                <li>Nama lengkap, alamat email, dan nomor telepon.</li>
                <li>Alamat pengiriman dan tagihan.</li>
                <li>Riwayat transaksi dan interaksi dengan layanan pelanggan (CRM).</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-2">2. Penggunaan Informasi</h3>
            <p>Informasi yang kami kumpulkan digunakan untuk:</p>
            <ul class="list-disc pl-5 space-y-2">
                <li>Memproses dan mengirimkan pesanan Anda.</li>
                <li>Meningkatkan layanan pelanggan dan membalas pertanyaan Anda.</li>
                <li>Mengirimkan informasi promo atau diskon, jika Anda memilih untuk berlangganan notifikasi kami.</li>
                <li>Keperluan analitik internal menggunakan sistem ERP untuk meningkatkan kualitas layanan.</li>
            </ul>

            <h3 class="text-xl font-bold text-gray-800 mt-8 mb-2">3. Keamanan Data</h3>
            <p>Sistem backend kami menggunakan enkripsi standar industri (termasuk *hashing password* via sistem keamanan Laravel) untuk menjaga keamanan data pribadi Anda. Kami tidak akan pernah menjual informasi pribadi Anda kepada pihak ketiga.</p>
        </div>
    </div>
</div>
@endsection