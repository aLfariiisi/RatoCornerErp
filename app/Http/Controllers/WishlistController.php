<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Menampilkan daftar wishlist milik user yang login
    public function index()
    {
        $wishlists = Wishlist::with(['product.category', 'product.stock'])
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    // Menambahkan produk ke wishlist
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // Cek apakah sudah ada di wishlist sebelumnya agar tidak duplikat
        $exists = Wishlist::where('user_id', Auth::id())
                          ->where('product_id', $request->product_id)
                          ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
            return back()->with('success', 'Produk berhasil ditambahkan ke wishlist.');
        }

        return back()->with('info', 'Produk sudah ada di dalam wishlist Anda.');
    }

    // Menghapus produk dari wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->findOrFail($id);
        $wishlist->delete();

        return back()->with('success', 'Produk berhasil dihapus dari wishlist.');
    }
}