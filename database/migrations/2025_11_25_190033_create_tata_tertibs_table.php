<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tata_tertibs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul
            $table->text('description')->nullable(); // Deskripsi singkat
            $table->string('pdf_file'); // File PDF
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tata_tertibs');
    }
};