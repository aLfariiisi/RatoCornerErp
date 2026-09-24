<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    // 1. Daftar Pelanggan
    public function index()
    {
        // Hanya ambil data user yang memiliki role 'pengguna'
        $customers = User::role('pengguna')->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    // 2. Tambah Pelanggan Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Otomatis berikan role 'pengguna'
        $customer->assignRole('pengguna');

        return back()->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    // 3. Riwayat Pesanan Pelanggan (Detail)
    public function show(User $customer)
    {
        // Pastikan admin tidak membuka detail akun sesama admin melalui URL ini
        if (!$customer->hasRole('pengguna')) {
            abort(404, 'Data pelanggan tidak ditemukan.');
        }

        // Load data pesanan pelanggan beserta detail produk, pembayaran, dan pengiriman
        $customer->load(['orders.items.product', 'orders.payment', 'orders.shipping']);
        
        return view('admin.customers.show', compact('customer'));
    }

    // 4. Edit Pelanggan
    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id, // Abaikan email sendiri saat validasi
            'password' => 'nullable|min:8', // Password opsional saat edit
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika admin mengisi password baru, update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);

        return back()->with('success', 'Data Pelanggan berhasil diperbarui.');
    }

    // 5. Hapus Pelanggan
    public function destroy(User $customer)
    {
        // Hapus pelanggan (karena cascadeOnDelete, otomatis riwayat ordernya akan terhapus jika Anda mengaturnya demikian, atau berikan validasi tambahan jika tidak boleh dihapus jika ada order)
        $customer->delete();
        return back()->with('success', 'Data pelanggan berhasil dihapus.');
    }
}