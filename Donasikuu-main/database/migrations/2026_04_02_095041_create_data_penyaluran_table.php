<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_penyaluran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_donasi')->constrained('data_donasi')->onDelete('cascade');
            $table->foreignId('id_penerima')->constrained('data_penerima')->onDelete('cascade');
            $table->date('tanggal_penyaluran');
            $table->string('bukti_foto')->nullable();
            $table->string('status')->default('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_penyaluran');
    }
};