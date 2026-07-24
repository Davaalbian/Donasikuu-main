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
        Schema::create('data_donasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_kategori');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->string('kondisi');
            $table->string('metode_pengiriman');
            $table->date('tanggal_pengiriman');
            $table->string('foto')->nullable();
            $table->string('status_donasi')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_donasis');
    }
};
