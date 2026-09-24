<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReturnExchangeController;
use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

// =========================================================
// AKSES PUBLIK (Bisa diakses oleh siapa saja tanpa login)
// =========================================================
Route::get('/', function () {
    $products = Product::where('is_active', true)->latest()->take(4)->get();
    return view('welcome', compact('products'));
})->name('home');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/faq', 'faq')->name('faq');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/testimonials', 'testimonials')->name('testimonials');
Route::view('/blog', 'blog.index')->name('blog');
Route::view('/promo', 'promo.index')->name('promo');

// Halaman Katalog Produk (Terhubung ke Database ERP & Mendukung Filter Kategori)
Route::get('/products', function (Request $request) {
    $categories = \App\Models\Category::all(); 
    
    $query = Product::with(['category'])->where('is_active', true);

    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    $products = $query->latest()->paginate(12)->withQueryString();

    return view('products.index', compact('products', 'categories'));
})->name('products.index');

// Halaman Detail Produk Dinamis
Route::get('/products/{product}', function (Product $product) {
    $product->load(['category', 'stock']);
    return view('products.show', compact('product'));
})->name('products.show');

// Rute Keranjang Belanja
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');


// =========================================================
// AKSES CUSTOMER (Hanya untuk pengguna yang sudah login)
// =========================================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Customer standar Breeze
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Rute Update Profil dari Dashboard
    Route::post('/dashboard/update', function (Request $request) {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:8',
        ]);

        $user->update([
            'name' => $request->name,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return back()->with('success', 'Profil akun berhasil diperbarui.');
    })->name('user.profile.update');
    
    // Fitur Checkout & Pembayaran Terhubung Database ERP
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.process');
    Route::get('/checkout/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    
    // Fitur Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/add', [WishlistController::class, 'store'])->name('wishlist.add');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');

});


// =========================================================
// AKSES ADMINISTRATOR (ERP Backend)
// =========================================================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        // [UPDATE F&B] Mengubah 'shipped' menjadi 'served'
        $totalIncome = \App\Models\Order::whereIn('status', ['served', 'completed'])->sum('total_price');
        $expenses = \App\Models\Expense::sum('amount');
        $netProfit = $totalIncome - $expenses;
        
        $netProfitMargin = $totalIncome > 0 ? round(($netProfit / $totalIncome) * 100) : 0;
        
        $healthPercentage = 0;
        if ($totalIncome > 0) {
            $healthPercentage = min(round(($netProfit / $totalIncome) * 100), 100);
            if ($healthPercentage < 0) $healthPercentage = 0;
        }

        // [UPDATE F&B] Mengubah 'shipped' menjadi 'served'
        $totalOrders = \App\Models\Order::whereIn('status', ['served', 'completed'])->count();

        return view('admin.dashboard', compact('totalIncome', 'expenses', 'netProfit', 'netProfitMargin', 'healthPercentage', 'totalOrders'));
    })->name('dashboard');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    Route::get('/returns', [ReturnExchangeController::class, 'index'])->name('returns.index');
    Route::get('/returns/{returnExchange}', [ReturnExchangeController::class, 'show'])->name('returns.show');
    Route::patch('/returns/{returnExchange}/status', [ReturnExchangeController::class, 'updateStatus'])->name('returns.updateStatus');
    
    Route::get('/crm/customers', [CrmController::class, 'index'])->name('crm.customers.index');
    Route::get('/crm/customers/{customer}', [CrmController::class, 'show'])->name('crm.customers.show');
    Route::post('/crm/customers/{customer}/interactions', [CrmController::class, 'storeInteraction'])->name('crm.interactions.store');
    
    Route::resource('/users', UserController::class);
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    Route::get('/analytics', [ReportController::class, 'analytics'])->name('reports.analytics');
    Route::get('/financials', [ReportController::class, 'financials'])->name('reports.financials');
    
    // [RUTE BARU] Untuk menyimpan data pengeluaran operasional
    Route::post('/expenses/store', [ReportController::class, 'storeExpense'])->name('expenses.store');
    
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::put('/stocks/{stock}', [StockController::class, 'update'])->name('stocks.update');

    Route::resource('/categories', CategoryController::class)->except(['show']);
    Route::resource('/products', ProductController::class)->except(['show']);
    Route::resource('/customers', CustomerController::class)->except(['create', 'edit']);
    
    Route::resource('/payments', PaymentController::class)->except(['create', 'edit', 'show']);
    Route::post('/payments/methods', [PaymentController::class, 'storeMethod'])->name('payment-methods.store');
    Route::put('/payments/methods/{paymentMethod}', [PaymentController::class, 'updateMethod'])->name('payment-methods.update');
    Route::delete('/payments/methods/{paymentMethod}', [PaymentController::class, 'destroyMethod'])->name('payment-methods.destroy');
    
    Route::get('/shippings', [ShippingController::class, 'index'])->name('shippings.index');
    Route::post('/shippings/methods', [ShippingController::class, 'storeMethod'])->name('shipping-methods.store');
    Route::put('/shippings/methods/{shippingMethod}', [ShippingController::class, 'updateMethod'])->name('shipping-methods.update');
    Route::delete('/shippings/methods/{shippingMethod}', [ShippingController::class, 'destroyMethod'])->name('shipping-methods.destroy');

});

// PENTING: Memuat rute autentikasi bawaan Laravel Breeze (/login, /register, dll)
require __DIR__.'/auth.php';