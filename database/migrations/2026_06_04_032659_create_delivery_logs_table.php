<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Menghubungkan ke tabel orders
            $table->string('status');               // Menyimpan status (contoh: Dikirim)
            $table->text('keterangan');             // Menyimpan catatan tracking
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_logs');
    }
};