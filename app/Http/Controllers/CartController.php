<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // 1. Menampilkan Daftar Keranjang Belanja
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // 2. Menambahkan Produk ke Keranjang
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::with('stock')->findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        // Cek apakah produk sudah ada di keranjang
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            // Validasi sederhana terhadap stok jika ada
            if ($product->stock && $newQuantity > $product->stock->quantity) {
                return back()->with('error', "Stok produk {$product->name} tidak mencukupi.");
            }

            $cart[$product->id]['quantity'] = $newQuantity;
            $cart[$product->id]['image'] = $product->image; // Update gambar juga
        } else {
            // Jika belum ada, masukkan item baru ke array session keranjang (TERMASUK GAMBAR)
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => $quantity,
                "sku" => $product->sku,
                "image" => $product->image // <--- INI YANG KURANG SEBELUMNYA
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // 3. Memperbarui Kuantitas Produk di Keranjang
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui.');
    }

    // 4. Menghapus Produk dari Keranjang
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}