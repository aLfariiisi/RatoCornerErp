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
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('shipping_method'); // JNE, J&T, COD, dll
            $table->string('tracking_number')->nullable(); // Resi pengiriman
            $table->text('shipping_address');
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->string('status')->default('pending'); // pending, shipped, delivered
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
