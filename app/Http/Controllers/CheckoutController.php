<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\PaymentMethod;

class CheckoutController extends Controller
{
    // 1. Menampilkan Halaman Checkout secara Dinamis dari Database ERP
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        // Ambil data metode pembayaran aktif dari database admin ERP
        $paymentMethods = PaymentMethod::all();

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total', 'paymentMethods'));
    }

    // 2. Memproses Transaksi Checkout (Order, Stock, Payment)
    public function store(Request $request)
    {
        // Validasi diubah menjadi penangkapan Nomor Meja
        $request->validate([
            'nomor_meja' => 'required|integer|min:1|max:50', // maximal meja
            'payment_method' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        DB::beginTransaction();
        
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'INV-' . date('Ymd') . '-' . Str::upper(Str::random(5)),
                'nomor_meja' => $request->nomor_meja, // Memasukkan nomor meja ke database
                'status' => 'pending',
                'total_price' => 0,
            ]);

            $totalPrice = 0;

            foreach ($cart as $productId => $item) {
                $product = Product::with('stock')->findOrFail($productId);
                
                if (!$product->stock || $product->stock->quantity < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                }

                $product->stock->decrement('quantity', $item['quantity']);

                $subtotal = $item['price'] * $item['quantity'];
                $totalPrice += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Total murni tanpa ongkir
            $order->update(['total_price' => $totalPrice]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $totalPrice,
            ]);

            DB::commit();

            session()->forget('cart');

            return redirect()->route('checkout.payment', $order->id)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // 3. Menampilkan Halaman Pembayaran Berdasarkan Pesanan
    public function payment(Order $order)
    {
        if (auth()->id() !== $order->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $order->load(['items.product', 'payment']);

        return view('checkout.payment', compact('order'));
    }
}