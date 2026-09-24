<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // ==========================================
    // BAGIAN 1: MANAJEMEN TRANSAKSI PEMBAYARAN
    // ==========================================

    // Menampilkan Daftar Pembayaran & Daftar Metode Pembayaran
    public function index()
    {
        // Ambil data pembayaran beserta pesanan dan pelanggannya
        $payments = Payment::with(['order.user'])->latest()->paginate(10);
        
        // Ambil data metode pembayaran yang tersedia (Bank, e-Wallet, dll)
        $paymentMethods = PaymentMethod::latest()->get();
        
        // Ambil pesanan yang belum lunas (untuk form tambah pembayaran manual)
        $orders = Order::where('status', 'pending')->get();

        return view('admin.payments.index', compact('payments', 'paymentMethods', 'orders'));
    }

    // Tambah Pembayaran Manual (Misal: Kasir menerima uang cash/transfer langsung)
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        Payment::create([
            'order_id' => $request->order_id,
            'payment_method' => $request->payment_method,
            'payment_status' => 'success', // Karena diinput manual oleh Admin, otomatis dianggap Lunas
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);

        return back()->with('success', 'Data Pembayaran berhasil dicatat manual.');
    }

    // Edit Pembayaran (Misal: Mengubah status dari pending menjadi success)
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,success,failed',
            'payment_method' => 'required|string|max:255',
        ]);

        $payment->update([
            'payment_status' => $request->payment_status,
            'payment_method' => $request->payment_method,
        ]);

        return back()->with('success', 'Status Pembayaran berhasil diperbarui.');
    }

    // Hapus Data Pembayaran (Hanya jika terjadi kesalahan pencatatan)
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return back()->with('success', 'Data Pembayaran berhasil dihapus.');
    }

    // ==========================================
    // BAGIAN 2: MANAJEMEN METODE PEMBAYARAN
    // ==========================================

    // Tambah Metode Pembayaran (Rekening Bank / e-Wallet Baru)
    public function storeMethod(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'account_name' => 'nullable|string|max:255',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => true,
        ]);

        return back()->with('success', 'Metode Pembayaran baru berhasil ditambahkan.');
    }

    // Edit Metode Pembayaran
    public function updateMethod(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'account_name' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $paymentMethod->update([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Data Metode Pembayaran berhasil diperbarui.');
    }

    // Hapus Metode Pembayaran
    public function destroyMethod(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return back()->with('success', 'Metode Pembayaran berhasil dihapus.');
    }
}