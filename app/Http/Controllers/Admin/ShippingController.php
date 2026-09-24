<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    // 1. Tampilkan Daftar Pengiriman (Resi) & Daftar Kurir (Biaya)
    public function index()
    {
        // Daftar transaksi pengiriman dari pesanan pelanggan
        $shippings = Shipping::with('order.user')->latest()->paginate(10);
        
        // Daftar metode/kurir pengiriman yang bisa diatur biayanya
        $methods = ShippingMethod::latest()->get();

        return view('admin.shippings.index', compact('shippings', 'methods'));
    }

    // 2. Tambah Kurir / Metode Pengiriman Baru
    public function storeMethod(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
        ]);

        ShippingMethod::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'is_active' => true,
        ]);

        return back()->with('success', 'Metode Pengiriman berhasil ditambahkan.');
    }

    // 3. Edit Kurir & Biaya Pengiriman
    public function updateMethod(Request $request, ShippingMethod $shippingMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $shippingMethod->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Biaya dan Data Pengiriman berhasil diperbarui.');
    }

    // 4. Hapus Kurir / Metode Pengiriman
    public function destroyMethod(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return back()->with('success', 'Metode Pengiriman berhasil dihapus.');
    }
}