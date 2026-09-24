@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Website</h1>
    <p class="text-sm text-gray-500">Ubah informasi identitas dan konfigurasi utama website.</p>
</div>

<div class="max-w-2xl bg-white rounded-xl shadow-sm border border-orange-100 p-6">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Situs (Site Name)</label>
            <input type="text" name="site_name" value="{{ old('site_name', $setting->site_name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email Kontak</label>
            <input type="email" name="email" value="{{ old('email', $setting->email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $setting->phone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">{{ old('address', $setting->address) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Logo Website</label>
            @if($setting->logo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $setting->logo) }}" class="h-12 object-contain">
                </div>
            @endif
            <input type="file" name="logo" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
            @if($setting->favicon)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $setting->favicon) }}" class="h-8 object-contain">
                </div>
            @endif
            <input type="file" name="favicon" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-5 py-2.5 bg-primary text-white rounded-lg text-sm font-medium hover:bg-opacity-90 transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection