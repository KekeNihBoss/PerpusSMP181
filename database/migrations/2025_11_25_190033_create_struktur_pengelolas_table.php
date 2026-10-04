<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_pengelolas', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama
            $table->string('position'); // Jabatan (Ketua, Wakil, dll)
            $table->string('photo')->nullable(); // Foto
            $table->text('description')->nullable(); // Deskripsi singkat
            $table->integer('order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_pengelolas');
    }
};