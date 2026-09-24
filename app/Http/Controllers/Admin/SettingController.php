<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // Menampilkan Form Pengaturan
    public function edit()
    {
        // Cari data pengaturan pertama. Jika tabel masih kosong, otomatis buatkan nilai default.
        $setting = Setting::firstOrCreate(
            ['id' => 1], // Selalu gunakan ID 1
            ['site_name' => 'ERP Kelompok 7']
        );

        return view('admin.settings.edit', compact('setting'));
    }

    // Memproses Perubahan dan Upload Gambar
    public function update(Request $request)
    {
        // Ambil data pengaturan (pasti ada karena sudah dibuat di method edit)
        $setting = Setting::findOrFail(1);

        // Validasi input form
        $request->validate([
            'site_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Maksimal 2MB
            'favicon' => 'nullable|image|mimes:png,ico|max:1024', // Maksimal 1MB
        ]);

        // Ambil data teks saja
        $data = $request->only(['site_name', 'email', 'phone', 'address']);

        // Logika Upload Gambar Logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama dari server jika ada
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            // Simpan gambar baru ke folder storage/app/public/settings
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        // Logika Upload Gambar Favicon
        if ($request->hasFile('favicon')) {
            // Hapus favicon lama
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            // Simpan favicon baru
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        // Simpan semua perubahan ke database
        $setting->update($data);

        return back()->with('success', 'Pengaturan Website berhasil diperbarui.');
    }
}
