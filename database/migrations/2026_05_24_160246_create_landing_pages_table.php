<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('DONASIKU');
            $table->string('hero_title')->default('Donasi Mudah Bersama DONASIKU.');
            $table->string('hero_description')->default('Platform donasi barang layak pakai untuk warga RW 03.');
            $table->string('hero_background')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
