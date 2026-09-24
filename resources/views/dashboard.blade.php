@extends('layouts.frontend')
@section('title', 'Akun Saya')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4 flex flex-col md:flex-row gap-8">
    
    <!-- Sidebar Menu Akun -->
    <div class="w-full md:w-1/4">
        <div class="bg-white p-6 rounded-lg shadow-sm border mb-6">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-3 flex items-center justify-center text-2xl font-bold text-gray-500">
                    {{ substr(Auth::user()->name ?? 'User', 0, 1) }}
                </div>
                <h3 class="font-bold text-lg">{{ Auth::user()->name ?? 'Nama Pelanggan' }}</h3>
                <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'email@domain.com' }}</p>
            </div>
            
            <nav class="flex flex-col gap-2">
                <!-- Tambahan Menu Khusus Admin -->
                @role('admin')
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 bg-red-50 text-red-600 border border-red-200 font-semibold rounded transition hover:bg-red-100 mb-2">
                    <i class="fas fa-cogs"></i> Masuk ERP Admin
                </a>
                @endrole

                <!-- Menu Standar Pengguna -->
                <a href="#riwayat" class="flex items-center gap-3 p-3 bg-gray-50 text-[#c28455] font-semibold rounded transition">
                    <i class="fas fa-shopping-bag"></i> Riwayat Pesanan
                </a>
                <a href="#pengaturan" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-50 rounded transition">
                    <i class="fas fa-user-cog"></i> Pengaturan Akun
                </a>
                <a href="/wishlist" class="flex items-center gap-3 p-3 text-gray-600 hover:bg-gray-50 rounded transition">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4 border-t pt-4">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 rounded transition">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Konten Utama Dashboard -->
    <div class="w-full md:w-3/4">
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">{{ session('error') }}</div>
        @endif

        <!-- Tab: Riwayat Pesanan (Dinamis dari Database Order milik User) -->
        <div class="bg-white p-6 rounded-lg shadow-sm border mb-8" id="riwayat">
            <h2 class="text-2xl font-bold mb-6 border-b pb-2">Riwayat Pesanan</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 font-semibold text-sm">Nomor Pesanan</th>
                            <th class="p-4 font-semibold text-sm">Tanggal</th>
                            <th class="p-4 font-semibold text-sm">Status</th>
                            <th class="p-4 font-semibold text-sm">Total Belanja</th>
                            <th class="p-4 font-semibold text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @php
                            $orders = \App\Models\Order::where('user_id', Auth::id())->latest()->get();
                        @endphp

                        @forelse($orders as $order)
                        <tr>
                            <td class="p-4 font-bold text-gray-700">{{ $order->order_number }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                @if($order->status == 'completed')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Dibatalkan</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="p-4 font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <a href="{{ route('checkout.payment', $order->id) }}" class="text-blue-500 hover:underline text-sm font-semibold">Detail / Bayar</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Belum ada riwayat pesanan yang dilakukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab: Pengaturan Akun -->
        <div class="bg-white p-6 rounded-lg shadow-sm border" id="pengaturan">
            <h2 class="text-2xl font-bold mb-6 border-b pb-2">Pengaturan Profil</h2>
            
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" required class="w-full border p-2 rounded focus:outline-none focus:border-[#c28455]">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" class="w-full border p-2 rounded bg-gray-50" readonly>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-600 mb-1">Password Baru (Kosongkan jika tidak ingin ganti)</label>
                    <input type="password" name="password" class="w-full border p-2 rounded focus:outline-none focus:border-[#c28455]">
                </div>
                <button type="submit" class="bg-[#1a1311] text-white px-6 py-2 rounded hover:bg-[#c28455] transition">Simpan Perubahan</button>
            </form>
        </div>

    </div>
</div>
@endsection