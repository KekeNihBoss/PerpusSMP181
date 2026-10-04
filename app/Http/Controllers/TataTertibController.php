<?php

namespace App\Http\Controllers;

use App\Models\TataTertib;
use Illuminate\Http\Request;

class TataTertibController extends Controller
{
    public function index()
    {
        $tataTertib = TataTertib::where('is_active', true)->first();
        
        return view('tata-tertib', compact('tataTertib'));
    }
}