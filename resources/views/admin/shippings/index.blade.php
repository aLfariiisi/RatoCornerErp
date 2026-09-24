@extends('layouts.admin')
@section('title', 'Manajemen Pengiriman')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengiriman & Kurir</h1>
            <p class="text-sm text-gray-500">Kelola tarif kurir dan pantau pengiriman pesanan customer secara real-time.</p>
        </div>
    </div>

    <!-- Bagian 1: Tambah Metode/Kurir Pengiriman Baru -->
    <div class="bg-white shadow-sm rounded-lg p-6 mb-8 border border-orange-100">
        <h2 class="text-lg font-bold text-gray-800 mb-4"><i class="fa-solid fa-plus-circle text-primary mr-2"></i> Tambah Kurir / Metode Pengiriman</h2>
        
        <form action="{{ route('admin.shipping-methods.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kurir / Layanan</label>
                <input type="text" name="name" required placeholder="Contoh: GrabExpress / Kurir Toko" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Ongkir (Rp)</label>
                <input type="number" name="cost" required placeholder="15000" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-2 focus:ring-primary focus:outline-none">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary hover:bg-[#a66a40] text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                    Simpan Kurir Baru
                </button>
            </div>
        </form>
    </div>

    <!-- Bagian 2: Daftar Tarif Kurir yang Aktif -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-orange-100 mb-8">
        <div class="p-4 bg-orange-50/50 border-b border-orange-100 font-bold text-gray-700">
            <i class="fa-solid fa-truck-fast mr-2 text-primary"></i> Daftar Tarif Kurir Tersedia
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b text-gray-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="p-3">Nama Kurir</th>
                    <th class="p-3">Tarif / Ongkir</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($methods as $method)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-3 font-semibold text-gray-800">{{ $method->name }}</td>
                    <td class="p-3 font-bold text-primary">Rp {{ number_format($method->cost, 0, ',', '.') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $method->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <form action="{{ route('admin.shipping-methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kurir ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold px-2 py-1 rounded bg-red-50 transition">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-400">Belum ada metode kurir yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Bagian 3: Riwayat Transaksi Pengiriman Customer -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-orange-100">
        <div class="p-4 bg-orange-50/50 border-b border-orange-100 font-bold text-gray-700">
            <i class="fa-solid fa-clipboard-list mr-2 text-primary"></i> Riwayat Pengiriman Pesanan Pelanggan
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b text-gray-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="p-4">No. Invoice</th>
                    <th class="p-4">Nama Customer</th>
                    <th class="p-4">Kurir Dipilih</th>
                    <th class="p-4">Alamat Tujuan</th>
                    <th class="p-4">Ongkir</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($shippings as $shipping)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-bold text-primary">
                        {{ $shipping->order->order_number ?? '-' }}
                    </td>
                    <td class="p-4 font-medium text-gray-800">
                        {{ $shipping->order->user->name ?? 'Guest' }}
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">
                            {{ $shipping->shipping_method }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-600 max-w-xs truncate" title="{{ $shipping->shipping_address }}">
                        {{ $shipping->shipping_address }}
                    </td>
                    <td class="p-4 font-semibold text-gray-800">
                        Rp {{ number_format($shipping->shipping_cost, 0, ',', '.') }}
                    </td>
                    <td class="p-4">
                        @if(isset($shipping->order))
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold 
                                @if($shipping->order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($shipping->order->status == 'completed') bg-green-100 text-green-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($shipping->order->status) }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center text-gray-400">
                        <i class="fa-solid fa-truck-ramp-box text-5xl mb-3 text-gray-300"></i>
                        <p class="text-base font-medium">Belum ada data pengiriman dari pesanan customer.</p>
                        <p class="text-xs text-gray-400 mt-1">Data akan masuk otomatis setelah ada customer yang melakukan checkout.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <div class="mt-6">
        {{ $shippings->links() }}
    </div>
</div>
@endsection