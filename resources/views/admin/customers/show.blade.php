@extends('layouts.admin')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pelanggan: {{ $customer->name }}</h1>
        <p class="text-sm text-gray-500">Email: {{ $customer->email }}</p>
    </div>
    <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pesanan Pelanggan</h3>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-4">No. Invoice</th>
                <th class="py-3 px-4">Total Harga</th>
                <th class="py-3 px-4 text-center">Status Pesanan</th>
                <th class="py-3 px-4 text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($customer->orders ?? [] as $order)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-3 px-4 font-semibold text-primary">{{ $order->order_number }}</td>
                <td class="py-3 px-4 text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="py-3 px-4 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-primary">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="py-3 px-4 text-center text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 text-center text-gray-400">Pelanggan ini belum memiliki riwayat pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection