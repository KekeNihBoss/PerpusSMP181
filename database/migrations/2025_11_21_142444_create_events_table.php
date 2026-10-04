<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul event
            $table->string('slug')->unique(); // Slug untuk URL
            $table->text('description'); // Deskripsi event
            $table->text('content')->nullable(); // Konten lengkap
            $table->string('author')->nullable(); // Penulis
            $table->string('category')->default('Event'); // Kategori
            $table->integer('views')->default(0); // Jumlah view
            $table->string('image')->nullable(); // Gambar event
            $table->date('event_date'); // Tanggal event
            $table->string('location')->nullable(); // Lokasi event
            $table->boolean('is_active')->default(true); // Tampil/tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};