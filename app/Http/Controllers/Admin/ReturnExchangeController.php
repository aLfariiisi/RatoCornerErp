<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnExchange;
use Illuminate\Http\Request;

class ReturnExchangeController extends Controller
{
    // Tampilkan semua permintaan return/exchange
    public function index()
    {
        $returns = ReturnExchange::with(['order', 'user'])->latest()->paginate(15);
        return view('admin.returns.index', compact('returns'));
    }

    // Lihat detail permintaan
    public function show(ReturnExchange $returnExchange)
    {
        // Load relasi order beserta produknya agar admin bisa mengecek barang apa yang dikembalikan
        $returnExchange->load(['order.items.product', 'user']);
        return view('admin.returns.show', compact('returnExchange'));
    }

    // Proses terima/tolak permintaan
    public function updateStatus(Request $request, ReturnExchange $returnExchange)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'admin_notes' => 'nullable|string'
        ]);

        $returnExchange->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        // Catatan Logika ERP Tambahan:
        // Jika status 'approved' dan type 'return', Anda nanti bisa memanggil API Refund (Payment Gateway) di sini.
        // Jika status 'completed', Anda bisa memanggil fungsi penambahan kembali stok ke tabel Stock.

        return back()->with('success', 'Status pengembalian berhasil diperbarui.');
    }
}