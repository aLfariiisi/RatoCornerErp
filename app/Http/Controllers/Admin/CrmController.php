<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerInteraction;
use Illuminate\Http\Request;

class CrmController extends Controller
{
    // 1. Tampilkan Daftar Leads/Pelanggan beserta Statistik Cepat
    public function index()
    {
        // Hanya ambil user dengan role 'pengguna'
        $customers = User::role('pengguna')
            ->withCount('orders') // Hitung jumlah pesanan
            ->withSum('orders', 'total_price') // Hitung total uang yang dihabiskan
            ->latest()
            ->paginate(15);
            
        return view('admin.crm.index', compact('customers'));
    }

    // 2. Detail Analisis Pelanggan & Riwayat Interaksi
    public function show(User $customer)
    {
        // Ambil data pesanan, pengembalian, dan riwayat interaksi pelanggan tersebut
        $customer->load(['orders', 'returnExchanges']);
        
        $interactions = CustomerInteraction::where('user_id', $customer->id)
                            ->with('admin')
                            ->latest()
                            ->get();

        // Metrik Analitik Pelanggan (Customer Lifetime Value)
        $totalSpent = $customer->orders()->where('status', 'completed')->sum('total_price');
        $totalOrders = $customer->orders()->count();
        
        return view('admin.crm.show', compact('customer', 'interactions', 'totalSpent', 'totalOrders'));
    }

    // 3. Catat Interaksi/Keluhan Baru
    public function storeInteraction(Request $request, User $customer)
    {
        $request->validate([
            'type' => 'required|in:telepon,email,meeting,keluhan',
            'notes' => 'required|string',
            'interaction_date' => 'required|date',
        ]);

        CustomerInteraction::create([
            'user_id' => $customer->id,
            'admin_id' => auth()->id(), // Otomatis mencatat Admin yang sedang login
            'type' => $request->type,
            'notes' => $request->notes,
            'interaction_date' => $request->interaction_date,
        ]);

        return back()->with('success', 'Riwayat interaksi berhasil dicatat.');
    }
}
