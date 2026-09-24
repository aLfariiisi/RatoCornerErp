@extends('layouts.admin')

@section('title', 'Manajemen Return & Exchange')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Permintaan Return & Exchange</h1>
    <p class="text-sm text-gray-500">Kelola pengembalian atau penukaran barang dari pelanggan.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-orange-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                <th class="py-3 px-6">No. Invoice</th>
                <th class="py-3 px-6">Pelanggan</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            @forelse($returns as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="py-4 px-6 font-semibold text-primary">{{ $item->order->order_number ?? '-' }}</td>
                <td class="py-4 px-6 text-gray-800">{{ $item->user->name ?? '-' }}</td>
                <td class="py-4 px-6 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                        {{ $item->status == 'completed' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $item->status == 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $item->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $item->status == 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td class="py-4 px-6 text-center">
                    <a href="{{ route('admin.returns.show', $item->id) }}" class="text-primary hover:underline text-sm font-medium">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 text-center text-gray-400">Belum ada permintaan return atau exchange.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">
        {{ $returns->links() }}
    </div>
</div>
@endsection