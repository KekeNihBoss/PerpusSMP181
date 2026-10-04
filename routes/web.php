<?php

use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\StrukturPengelolaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TataTertibController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TemplateController;

// Route yang sudah ada
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/chart-data', [HomeController::class, 'chartData'])->name('chart.data');

// Alias route 'login' untuk redirect middleware auth (Filament tidak mendaftarkan route bernama 'login')
Route::get('/login', fn () => redirect()->route('filament.admin.auth.login'))->name('login');

// Template import Excel (admin)
Route::middleware('auth')->group(function () {
    Route::get('/templates/buku', [TemplateController::class, 'buku'])->name('templates.buku');
    Route::get('/templates/siswa', [TemplateController::class, 'siswa'])->name('templates.siswa');
});

// Route baru untuk navbar features
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('visi-misi');
Route::get('/struktur-pengelola', [StrukturPengelolaController::class, 'index'])->name('struktur-pengelola');
Route::get('/tata-tertib', [TataTertibController::class, 'index'])->name('tata-tertib');

// Route Blog/Event
Route::get('/blog', [EventController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [EventController::class, 'show'])->name('blog.show');

// Route Detail Buku
Route::get('/book/{id}', [BookController::class, 'show'])->name('book.show');

Route::get('/buku', [BookController::class, 'index'])->name('buku.index');
Route::get('/buku/{id}/{slug?}', [BookController::class, 'show'])->name('buku.show');
