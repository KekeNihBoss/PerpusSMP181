<?php

namespace App\Http\Controllers;

use App\Models\BookRecommendation;
use App\Models\DataBuku;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // ================================
    // DETAIL BUKU
    // ================================
    public function show($id)
    {
        // Ambil buku dari tabel DataBuku
        $buku = DataBuku::findOrFail($id);

        // Ambil BookRecommendation jika ada (optional)
        $book = BookRecommendation::where('id', $id)
            ->where('is_active', true)
            ->first();

        // related books dari BookRecommendation (optional)
        $relatedBooks = collect();
        if ($book) {
            $relatedBooks = BookRecommendation::where('is_active', true)
                ->where('category', $book->category)
                ->where('id', '!=', $book->id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        return view('book.show', compact('buku', 'book', 'relatedBooks'));
    }

    // ================================
    // LISTING BUKU
    // ================================
    public function index(Request $request)
    {
        $view = $request->view ?? 'grid'; // default grid

        $query = DataBuku::query();

        // search
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // filter kategori
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        $buku = $query->paginate(12);
        $kategoriList = DataBuku::select('kategori')->distinct()->pluck('kategori');

        return view('book.index', compact('buku', 'view', 'kategoriList'));
    }
}
