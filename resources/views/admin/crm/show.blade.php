@extends('layouts.admin')

@section('title', 'Analisis CRM Pelanggan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">CRM Pelanggan: {{ $customer->name }}</h1>
        <p class="text-sm text-gray-500">Kelola interaksi dan pantau nilai analitik pelanggan.</p>
    </div>
    <a href="{{ route('admin.crm.customers.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
    </a>
</div>

<!-- Metrik Analitik CLV -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100">
        <p class="text-sm text-gray-500 mb-1">Total Belanja (CLV)</p>
        <h3 class="text-2xl font-bold text-primary">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-orange-100">
        <p class="text-sm text-gray-500 mb-1">Total Pesanan Selesai</p>
        <h3 class="text-2xl font-bold text-gray-800">{{ $totalOrders ?? 0 }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Riwayat Interaksi -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Interaksi / Keluhan</h3>
        <div class="space-y-4">
            @forelse($interactions ?? [] as $interaction)
            <div class="border-b pb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="px-2 py-0.5 rounded text-xs font-semibold bg-orange-100 text-primary uppercase">{{ $interaction->type }}</span>
                    <span class="text-xs text-gray-400">{{ $interaction->interaction_date }}</span>
                </div>
                <p class="text-sm text-gray-700">{{ $interaction->notes }}</p>
                <p class="text-xs text-gray-500 mt-1">Dicatat oleh Admin: {{ $interaction->admin->name ?? '-' }}</p>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Belum ada catatan interaksi.</p>
            @endforelse
        </div>
    </div>

    <!-- Form Catat Interaksi Baru (Sesuai CrmController@storeInteraction) -->
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Catat Interaksi Baru</h3>
        <form action="{{ route('admin.crm.interactions.store', $customer->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Interaksi</label>
                <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-primary">
                    <option value="telepon">Telepon</option>
                    <option value="email">Email</option>
                    <option value="meeting">Meeting</option>
                    <option value="keluhan">Keluhan</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="interaction_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="notes" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary"></textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-opacity-90 transition">Simpan Catatan</button>
        </form>
    </div>
</div>
@endsection