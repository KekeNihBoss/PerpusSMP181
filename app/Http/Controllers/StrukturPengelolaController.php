<?php

namespace App\Http\Controllers;

use App\Models\StrukturPengelola;
use Illuminate\Http\Request;

class StrukturPengelolaController extends Controller
{
    public function index()
    {
        $pengelolas = StrukturPengelola::where('is_active', true)
                                       ->orderBy('order', 'asc')
                                       ->get();
        
        return view('struktur-pengelola', compact('pengelolas'));
    }
}