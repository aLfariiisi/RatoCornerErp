<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Tampilkan semua pesanan ERP
    public function index()
    {
        // Ambil data order beserta relasinya (Shipping dihapus)
        $orders = Order::with(['user', 'payment'])->latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }

    // Tampilkan detail satu pesanan
    public function show(Order $order)
    {
        $order->load(['items.product', 'payment', 'user']);
        return view('admin.orders.show', compact('order'));
    }

   // Update status pesanan (Konsep Dine-in)
   public function updateStatus(Request $request, Order $order)
   {
        $request->validate([
            'status' => 'required|in:pending,processing,served,completed,cancelled',
        ]);

        // Update status order utama
        $order->update(['status' => $request->status]);

        // Jika pesanan selesai, tandai lunas
        if ($request->status === 'completed' && $order->payment) {
            $order->payment()->update(['payment_status' => 'success']);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
   }
}