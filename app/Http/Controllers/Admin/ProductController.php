<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk handle file gambar

class ProductController extends Controller
{
    // Tampilkan daftar produk
    public function index()
    {
        $products = Product::with(['category'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru ke database (termasuk upload gambar)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi gambar
        ]);

        // Proses upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 1. Buat detail produk
        $product = Product::create([
            'category_id' => $request->category_id,
            'sku' => $request->sku,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath, // Simpan path gambar ke DB
            'is_active' => true,
        ]);

        // 2. Otomatis inisialisasi stok = 0
        Stock::create([
            'product_id' => $product->id,
            'quantity' => 0,
            'min_stock_alert' => 5,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan. Silakan atur jumlah stok di menu Manajemen Stok.');
    }

    // Tampilkan form edit produk (FUNGSI INI YANG SEBELUMNYA HILANG)
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update detail produk (termasuk ganti gambar)
    public function update(Request $request, Product $product)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi gambar
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
        ];

        // Proses ganti gambar jika user upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Detail Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        // Hapus file gambar dari storage sebelum menghapus data produk
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete(); // Otomatis hapus stok karena cascade
        return back()->with('success', 'Produk berhasil dihapus.');
    }
}