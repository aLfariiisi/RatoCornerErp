@extends('layouts.admin')

@section('title', 'CRM & Leads Pelanggan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">CRM & Analitik Pelanggan</h1>
    <p class="text-sm text-gray-500">Kelola interaksi dan pantau nilai belanja (Customer Lifetime Value).</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6">Pelanggan</th>
                <th class="py-3 px-6 text-center">Jumlah Pesanan</th>
                <th class="py-3 px-6">Total Belanja (CLV)</th>
                <th class="py-3 px-6 text-center">Aksi Interaksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($customers as $customer)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6">
                    <p class="font-semibold text-gray-800">{{ $customer->name }}</p>
                    <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                </td>
                <td class="py-4 px-6 text-center font-medium">{{ $customer->orders_count ?? 0 }}</td>
                <td class="py-4 px-6 font-semibold text-primary">Rp {{ number_format($customer->orders_sum_total_price ?? 0, 0, ',', '.') }}</td>
                <td class="py-4 px-6 text-center">
                    <a href="{{ route('admin.crm.customers.show', $customer->id) }}" class="bg-primary text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-opacity-90">Riwayat & Catatan</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 text-center text-gray-400">Belum ada data leads pelanggan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $customers->links() }}
    </div>
</div>
@endsection