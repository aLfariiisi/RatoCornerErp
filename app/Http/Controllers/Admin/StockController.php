<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    // 1. Halaman Daftar Stok & Peringatan Stok Habis
    public function index()
    {
        // Ambil semua data stok beserta nama produknya
        $stocks = Stock::with('product')->paginate(15);
        
        // Ambil khusus stok yang jumlahnya di bawah batas minimal (Peringatan Stok Habis)
        $lowStocks = Stock::with('product')
                          ->whereColumn('quantity', '<=', 'min_stock_alert')
                          ->get();

        return view('admin.stocks.index', compact('stocks', 'lowStocks'));
    }

    // 2. Update Jumlah Stok & Batas Peringatan (Edit)
    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'min_stock_alert' => 'required|integer|min:0',
            'type' => 'required|in:addition,subtraction,adjustment' // Tambah stok, kurangi, atau ubah total
        ]);

        // Logika Penambahan/Pengurangan Stok
        $newQuantity = $stock->quantity;
        if ($request->type === 'addition') {
            $newQuantity += $request->quantity;
        } elseif ($request->type === 'subtraction') {
            $newQuantity -= $request->quantity;
        } else {
            $newQuantity = $request->quantity; // Penyesuaian manual (adjustment)
        }

        // Update ke database
        $stock->update([
            'quantity' => $newQuantity,
            'min_stock_alert' => $request->min_stock_alert
        ]);

        return back()->with('success', 'Data stok produk berhasil diperbarui.');
    }
}