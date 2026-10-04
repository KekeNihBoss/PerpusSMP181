<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    public function index()
    {
        $visiMisi = VisiMisi::where('is_active', true)->first();
        
        return view('visi-misi', compact('visiMisi'));
    }
}