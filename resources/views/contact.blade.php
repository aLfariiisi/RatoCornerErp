@extends('layouts.frontend')
@section('title', 'Kontak Kami')

@section('content')
<div class="bg-[#fdfaf5] py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-serif font-bold italic text-gray-800 mb-4">Hubungi Kami</h1>
            <p class="text-gray-500">Punya pertanyaan, keluhan, atau saran? Jangan ragu untuk menghubungi kami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white p-8 rounded-xl shadow-sm border">
            
            <!-- Informasi Kontak & Peta -->
            <div>
                <h3 class="text-2xl font-bold mb-6">Informasi Kontak</h3>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="bg-[#1a1311] text-white p-3 rounded-full"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <p class="font-bold text-gray-800">Alamat</p>
                            <p class="text-gray-600">Jl. Kopi Nusantara No. 123, Jakarta Selatan, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-[#1a1311] text-white p-3 rounded-full"><i class="fas fa-phone-alt"></i></div>
                        <div>
                            <p class="font-bold text-gray-800">Telepon</p>
                            <p class="text-gray-600">+62 800-1234-435</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-[#1a1311] text-white p-3 rounded-full"><i class="fas fa-envelope"></i></div>
                        <div>
                            <p class="font-bold text-gray-800">Email</p>
                            <p class="text-gray-600">hello@ratocorner.com</p>
                        </div>
                    </div>
                </div>

                <!-- Google Maps (Embed Iframe) -->
                <div class="w-full h-64 bg-gray-200 rounded-lg overflow-hidden">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24089422033!2d106.75931215!3d-6.2297465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14d30079f01%3A0x2f59ea0733e3eb2!2sSouth%20Jakarta%2C%20South%20Jakarta%20City%2C%20Jakarta!5e0!3m2!1sen!2sid!4v1680000000000!5m2!1sen!2sid" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Form Kontak (Bisa diintegrasikan ke CrmController) -->
            <div>
                <h3 class="text-2xl font-bold mb-6">Kirim Pesan</h3>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-[#c28455]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-[#c28455]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subjek / Keperluan</label>
                        <select name="subject" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-[#c28455]">
                            <option value="Tanya Produk">Pertanyaan Produk</option>
                            <option value="Keluhan">Keluhan Pelanggan</option>
                            <option value="Kerjasama">Tawaran Kerjasama</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Anda</label>
                        <textarea name="message" rows="5" required class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-[#c28455]"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#1a1311] hover:bg-[#c28455] text-white font-bold py-3 rounded transition">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection