<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul buku
            $table->string('author'); // Penulis
            $table->text('description'); // Deskripsi buku
            $table->string('cover')->nullable(); // Cover buku
            $table->string('category')->nullable(); // Kategori (Fiksi, Non-Fiksi, dll)
            $table->integer('year')->nullable(); // Tahun terbit
            $table->boolean('is_active')->default(true); // Tampil/tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_recommendations');
    }
};