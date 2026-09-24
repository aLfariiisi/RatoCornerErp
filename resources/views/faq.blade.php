@extends('layouts.frontend')
@section('title', 'FAQ')

@section('content')
<div class="max-w-4xl mx-auto py-16 px-4">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-serif font-bold italic text-gray-800 mb-4">Frequently Asked Questions</h1>
        <p class="text-gray-500">Temukan jawaban untuk pertanyaan yang paling sering diajukan oleh pelanggan Rato Corner.</p>
    </div>

    <!-- Daftar Accordion FAQ -->
    <div class="space-y-4">
        
        <!-- Pertanyaan 1 -->
        <details class="group bg-white border rounded-lg shadow-sm cursor-pointer [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-5 font-semibold text-gray-800">
                Apakah biji kopi yang digunakan di Rato Corner hasil roasting sendiri?
                <span class="transition group-open:rotate-180">
                    <i class="fas fa-chevron-down text-[#c28455]"></i>
                </span>
            </summary>
            <div class="p-5 pt-0 text-gray-600 border-t mt-2">
                Ya, kami menyangrai (roasting) biji kopi kami sendiri bekerja sama dengan roastery lokal terbaik untuk menjaga kualitas dan kesegaran rasa dari setiap cangkir yang kami sajikan.
            </div>
        </details>

        <!-- Pertanyaan 2 -->
        <details class="group bg-white border rounded-lg shadow-sm cursor-pointer [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-5 font-semibold text-gray-800">
                Berapa lama waktu pengiriman untuk pesanan online?
                <span class="transition group-open:rotate-180">
                    <i class="fas fa-chevron-down text-[#c28455]"></i>
                </span>
            </summary>
            <div class="p-5 pt-0 text-gray-600 border-t mt-2">
                Waktu pengiriman bervariasi bergantung pada metode ekspedisi yang dipilih saat checkout. Rata-rata pengiriman Jabodetabek memakan waktu 1-2 hari kerja. Untuk pemesanan minuman via kurir lokal/COD, akan dikirimkan di hari yang sama.
            </div>
        </details>

        <!-- Pertanyaan 3 -->
        <details class="group bg-white border rounded-lg shadow-sm cursor-pointer [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-5 font-semibold text-gray-800">
                Metode pembayaran apa saja yang diterima?
                <span class="transition group-open:rotate-180">
                    <i class="fas fa-chevron-down text-[#c28455]"></i>
                </span>
            </summary>
            <div class="p-5 pt-0 text-gray-600 border-t mt-2">
                Kami menerima berbagai metode pembayaran melalui sistem ERP kami, termasuk Transfer Bank (BCA, Mandiri), e-Wallet (GoPay, OVO), serta sistem bayar di tempat (Cash on Delivery) untuk wilayah tertentu.
            </div>
        </details>

        <!-- Pertanyaan 4 -->
        <details class="group bg-white border rounded-lg shadow-sm cursor-pointer [&_summary::-webkit-details-marker]:hidden">
            <summary class="flex items-center justify-between p-5 font-semibold text-gray-800">
                Bagaimana jika produk yang saya terima rusak atau salah?
                <span class="transition group-open:rotate-180">
                    <i class="fas fa-chevron-down text-[#c28455]"></i>
                </span>
            </summary>
            <div class="p-5 pt-0 text-gray-600 border-t mt-2">
                Anda dapat mengajukan klaim pengembalian (Return/Exchange) melalui dashboard akun Anda pada bagian pesanan. Tim admin ERP kami akan memproses permintaan Anda dalam waktu maksimal 2x24 jam kerja.
            </div>
        </details>

    </div>
</div>
@endsection