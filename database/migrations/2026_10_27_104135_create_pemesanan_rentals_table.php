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
        Schema::create('pemesanan_rental', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemesan');
            $table->string('nama_paket');
            $table->integer('jumlah_hari');
            $table->string('opsi_driver');
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_rentals');
    }
};