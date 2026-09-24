@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Pembayaran</h1>
        <p class="text-sm text-gray-500">Kelola transaksi pembayaran dan metode pembayaran yang tersedia.</p>
    </div>
    <div class="space-x-2">
        <button onclick="document.getElementById('addPaymentModal').classList.remove('hidden')" class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
            <i class="fa-solid fa-plus mr-1"></i> Catat Pembayaran Manual
        </button>
        <button onclick="document.getElementById('addMethodModal').classList.remove('hidden')" class="bg-gray-800 hover:bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
            <i class="fa-solid fa-wallet mr-1"></i> Tambah Metode Bayar
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Tabel Daftar Transaksi Pembayaran -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Transaksi Pembayaran</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-orange-50 text-gray-700 text-xs uppercase tracking-wider border-b border-orange-100">
                    <th class="py-3 px-4">Invoice</th>
                    <th class="py-3 px-4">Metode</th>
                    <th class="py-3 px-4">Jumlah</th>
                    <th class="py-3 px-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($payments ?? [] as $payment)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 px-4 font-semibold text-primary">{{ $payment->order->order_number ?? '-' }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $payment->payment_method }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $payment->payment_status == 'success' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ ucfirst($payment->payment_status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-400">Belum ada data pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel Daftar Metode Pembayaran (Bank / e-Wallet) -->
    <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Metode Pembayaran Aktif</h3>
        <div class="space-y-4">
            @forelse($paymentMethods ?? [] as $method)
            <div class="border-b pb-3 flex justify-between items-center">
                <div>
                    <p class="font-semibold text-sm text-gray-800">{{ $method->name }}</p>
                    <p class="text-xs text-gray-500">{{ $method->account_number ?? 'No Rekening / Virtual' }}</p>
                </div>
                <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Hapus metode pembayaran ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">Belum ada metode pembayaran.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Catat Pembayaran Manual (Sesuai PaymentController@store) -->
<div id="addPaymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Catat Pembayaran Manual</h3>
            <button onclick="document.getElementById('addPaymentModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.payments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Pesanan (Pending)</label>
                <select name="order_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:border-primary">
                    <option value="">Pilih Nomor Pesanan</option>
                    @foreach($orders ?? [] as $ord)
                        <option value="{{ $ord->id }}">{{ $ord->order_number }} - Rp {{ number_format($ord->total_price, 0, ',', '.') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                <input type="text" name="payment_method" placeholder="Contoh: Transfer Bank BCA / Cash" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Amount)</label>
                <input type="number" name="amount" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                <input type="date" name="payment_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addPaymentModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Metode Pembayaran (Sesuai PaymentController@storeMethod) -->
<div id="addMethodModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Metode Pembayaran Baru</h3>
            <button onclick="document.getElementById('addMethodModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.payment-methods.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bank / e-Wallet</label>
                <input type="text" name="name" placeholder="Contoh: BCA / GoPay" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening / Akun</label>
                <input type="text" name="account_number" placeholder="Nomor Rekening" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Atas Nama</label>
                <input type="text" name="account_name" placeholder="Nama Pemilik Rekening" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('addMethodModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection