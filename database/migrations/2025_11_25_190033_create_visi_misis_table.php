<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visi_misis', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul
            $table->text('description')->nullable(); // Deskripsi singkat
            $table->string('pdf_file'); // File PDF
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visi_misis');
    }
};