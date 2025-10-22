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
        Schema::create('data_bukus', function (Blueprint $table) {
            $table->id();
            $table->string('idbuku');
            $table->string('judul');
            $table->string('kategori');
            $table->string('stokbuku');
            $table->string('nomorrak');
            $table->string('penerbit');
            $table->string('penulis');
            $table->string('tahunpembelian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bukus');
    }
};
