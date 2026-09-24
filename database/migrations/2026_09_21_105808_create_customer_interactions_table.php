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
        Schema::create('customer_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pelanggan yang dihubungi
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); // Admin/CS yang menangani
            $table->string('type'); // Contoh: telepon, email, meeting, keluhan
            $table->text('notes'); // Catatan percakapan/hasil interaksi
            $table->date('interaction_date'); // Tanggal interaksi terjadi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_interactions');
    }
};
