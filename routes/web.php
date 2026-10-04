<?php

use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\StrukturPengelolaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TataTertibController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookController;

// Route yang sudah ada
Route::get('/', [HomeController::class, 'index'])->name('home');

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
