<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('return_exchanges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Memudahkan query berdasarkan customer
            $table->string('type'); // 'return' (pengembalian dana) atau 'exchange' (tukar barang)
            $table->text('reason'); // Alasan pengembalian dari customer
            $table->string('status')->default('pending'); // pending, approved, rejected, completed
            $table->text('admin_notes')->nullable(); // Catatan dari admin (misal: alasan penolakan)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_exchanges');
    }
};
