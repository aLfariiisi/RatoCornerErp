<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    // Menampilkan Form Lacak Pesanan
    public function index()
    {
        return view('user.tracking.index'); // Nanti Anda buat form inputnya di view ini
    }

    // Memproses pencarian lacak pesanan
    public function track(Request $request)
    {
        $request->validate([
            'search_key' => 'required|string|min:5', // Input bisa berupa order_number atau resi
        ], [
            'search_key.required' => 'Silakan masukkan Nomor Pesanan atau Resi pengiriman.',
        ]);

        $searchKey = $request->search_key;

        // Logika pencarian cerdas: Cari di tabel orders ATAU di relasi shippings
        $order = Order::with(['shipping', 'items.product'])
            ->where('user_id', auth()->id()) // Keamanan: Pastikan hanya pesanan miliknya sendiri
            ->where(function($query) use ($searchKey) {
                $query->where('order_number', $searchKey)
                      ->orWhereHas('shipping', function($q) use ($searchKey) {
                          $q->where('tracking_number', $searchKey);
                      });
            })
            ->first();

        if (!$order) {
            return back()->with('error', 'Pesanan atau nomor resi tidak ditemukan. Pastikan nomor yang dimasukkan benar.');
        }

        // Kembalikan data pesanan ke halaman hasil pelacakan
        return view('user.tracking.result', compact('order'));
    }
}