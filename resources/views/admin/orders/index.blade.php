@extends('layouts.admin')

@section('title', 'Manajemen Pesanan ERP')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Daftar Pesanan ERP</h1>
    <p class="text-sm text-gray-500">Pantau transaksi pesanan masuk dan nomor meja pelanggan.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6">No. Invoice</th>
                <th class="py-3 px-6">Pelanggan</th>
                <th class="py-3 px-6 text-center">No. Meja</th>
                <th class="py-3 px-6">Total Harga</th>
                <th class="py-3 px-6 text-center">Status Pesanan</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-semibold text-primary">{{ $order->order_number }}</td>
                <td class="py-4 px-6 text-gray-800">{{ $order->user->name ?? 'Guest' }}</td>
                <td class="py-4 px-6 text-center font-bold text-gray-800">
                    <span class="bg-gray-100 px-3 py-1 rounded-md border border-gray-200">
                        {{ $order->nomor_meja ?? '-' }}
                    </span>
                </td>
                <td class="py-4 px-6 font-medium text-gray-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="py-4 px-6 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                        {{ $order->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $order->status == 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $order->status == 'served' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $order->status == 'completed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td class="py-4 px-6 text-center">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary hover:underline text-sm font-medium">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-6 text-center text-gray-400">Belum ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection