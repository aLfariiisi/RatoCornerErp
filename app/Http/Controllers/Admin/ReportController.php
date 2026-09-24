<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // 1. Halaman Analitik dan Statistik dengan Grafik (Pendapatan, Pengeluaran, Laba Bersih)
    public function analytics()
    {
        // Penyesuaian status F&B: Pendapatan dihitung jika pesanan served atau completed
        $totalSales = Order::whereIn('status', ['served', 'completed'])->sum('total_price');
        $totalOrders = Order::whereIn('status', ['served', 'completed'])->count();
        
        // Total Pengeluaran & Laba Bersih Keseluruhan
        $expenses = Expense::sum('amount');
        $netProfit = $totalSales - $expenses;

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['served', 'completed'])
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();
        
        // --- DATA GRAFIK BULANAN (PENDAPATAN, PENGELUARAN, LABA BERSIH) ---
        
        // A. Ambil Pendapatan per Bulan (Tahun Berjalan)
        $monthlySales = Order::whereIn('status', ['served', 'completed'])
            ->select(
                DB::raw('SUM(total_price) as total'),
                DB::raw('MONTH(created_at) as month')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        // B. Ambil Pengeluaran per Bulan (Tahun Berjalan) dari Tabel Expenses
        $monthlyExpenses = Expense::select(
                DB::raw('SUM(amount) as total'),
                DB::raw('MONTH(expense_date) as month')
            )
            ->whereYear('expense_date', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        $salesMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $salesData = [];
        $expenseData = [];
        $profitData = [];

        for ($i = 1; $i <= 12; $i++) {
            $revenue = $monthlySales[$i] ?? 0;
            $monthlyExp = $monthlyExpenses[$i] ?? 0;
            
            $salesData[] = $revenue;
            $expenseData[] = $monthlyExp;                    // Data pengeluaran bulanan
            $profitData[] = $revenue - $monthlyExp;          // Laba bersih bulanan
        }

        // Penyesuaian label status F&B
        $statusLabels = ['Pending', 'Processing', 'Served', 'Completed', 'Cancelled'];
        $statusCounts = [
            Order::where('status', 'pending')->count(),
            Order::where('status', 'processing')->count(),
            Order::where('status', 'served')->count(),
            Order::where('status', 'completed')->count(),
            Order::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.reports.analytics', compact(
            'totalSales', 
            'totalOrders', 
            'expenses', 
            'netProfit',
            'topProducts', 
            'salesMonths', 
            'salesData', 
            'expenseData', 
            'profitData', 
            'statusLabels', 
            'statusCounts'
        ));
    }

    // 2. Halaman Laporan Keuangan (Laba/Rugi) dengan Tabel Arus Kas Gabungan
    public function financials(Request $request)
    {
        // Ringkasan Keuangan
        $income = Order::whereIn('status', ['served', 'completed'])->sum('total_price');
        
        // Logika shippingIncome sudah dihapus karena tidak dipakai
        $expenses = Expense::sum('amount');
        $netProfit = $income - $expenses;

        // --- GABUNGKAN DATA PEMASUKAN & PENGELUARAN UNTUK SATU TABEL ---
        
        // 1. Ambil Pemasukan dari Order (Status Served atau Completed)
        $orderIncomes = Order::whereIn('status', ['served', 'completed'])
            ->get()
            ->map(function ($order) {
                return [
                    'date' => $order->updated_at ?? $order->created_at,
                    'description' => 'Pendapatan Penjualan - Inv: ' . $order->order_number,
                    'income' => $order->total_price,
                    'expense' => 0,
                ];
            });

        // 2. Ambil Pengeluaran dari Tabel Expenses
        $expenseRows = Expense::all()
            ->map(function ($exp) {
                return [
                    'date' => $exp->expense_date ?? $exp->created_at,
                    'description' => $exp->description,
                    'income' => 0,
                    'expense' => $exp->amount,
                ];
            });

        // Gabungkan koleksi dan urutkan berdasarkan tanggal terbaru
        $transactions = $orderIncomes->concat($expenseRows)->sortByDesc('date');

        return view('admin.reports.financials', compact(
            'income', 
            'expenses', 
            'netProfit', 
            'transactions'
        ));
    }

    // 3. Menyimpan Data Pengeluaran Operasional dari Form
    public function storeExpense(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|integer|min:1',
            // Validasi expense_date dihapus karena sudah tidak ada inputan dari user
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'expense_date' => now(), // <-- Laravel otomatis mengambil tanggal & jam detik ini
        ]);

        return back()->with('success', 'Data pengeluaran operasional berhasil dicatat!');
    }
}