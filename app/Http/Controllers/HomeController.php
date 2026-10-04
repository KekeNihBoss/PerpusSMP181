<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\BookRecommendation;
use App\Models\Principal;
use App\Models\Absen;
use App\Models\Pengembalian;
use App\Models\DataBuku as Book;
use App\Models\DataSiswa as Member;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('is_active', true)
                       ->latest()
                       ->take(6)
                       ->get();
        
        $bookRecommendations = BookRecommendation::where('is_active', true)
                                                 ->latest()
                                                 ->take(8)
                                                 ->get();
        
        $principal = Principal::where('is_active', true)->first();

        // ========================================
        // STATISTIK CARD
        // ========================================
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $activeBorrowings = Peminjaman::where('status', 'dipinjam')->count();
        $lateBorrowings = Peminjaman::where('status', 'terlambat')->count();
        $todayAbsences = Absen::whereDate('created_at', today())->count();

        // ========================================
        // FILTER GRAFIK (Default: 7 hari)
        // ========================================
        $chartFilter = $request->get('chart_filter', '7days');
        
        if ($chartFilter === 'month') {
            // Data 30 hari terakhir
            $days = 30;
            $last30Days = collect();
            for ($i = 29; $i >= 0; $i--) {
                $last30Days->push(Carbon::now()->subDays($i)->format('Y-m-d'));
            }
            
            // Absensi
            $absensiData = Absen::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('created_at', '>=', Carbon::now()->subDays(29)->startOfDay())
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->pluck('total', 'date');

            $absensiLabels = $last30Days->map(function($date) {
                return Carbon::parse($date)->format('d M');
            });
            
            $absensiValues = $last30Days->map(function($date) use ($absensiData) {
                return $absensiData->get($date, 0);
            });

            // Pengembalian
            $pengembalianData = Peminjaman::select(
                    DB::raw('DATE(updated_at) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('status', 'dikembalikan')
                ->where('updated_at', '>=', Carbon::now()->subDays(29)->startOfDay())
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->pluck('total', 'date');

            $pengembalianLabels = $last30Days->map(function($date) {
                return Carbon::parse($date)->format('d M');
            });
            
            $pengembalianValues = $last30Days->map(function($date) use ($pengembalianData) {
                return $pengembalianData->get($date, 0);
            });
            
        } else {
            // Data 7 hari terakhir (default)
            $last7Days = collect();
            for ($i = 6; $i >= 0; $i--) {
                $last7Days->push(Carbon::now()->subDays($i)->format('Y-m-d'));
            }
            
            // Absensi
            $absensiData = Absen::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->pluck('total', 'date');

            $absensiLabels = $last7Days->map(function($date) {
                return Carbon::parse($date)->format('d M');
            });
            
            $absensiValues = $last7Days->map(function($date) use ($absensiData) {
                return $absensiData->get($date, 0);
            });

            // Pengembalian
            $pengembalianData = Peminjaman::select(
                    DB::raw('DATE(updated_at) as date'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('status', 'dikembalikan')
                ->where('updated_at', '>=', Carbon::now()->subDays(6)->startOfDay())
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->pluck('total', 'date');

            $pengembalianLabels = $last7Days->map(function($date) {
                return Carbon::parse($date)->format('d M');
            });
            
            $pengembalianValues = $last7Days->map(function($date) use ($pengembalianData) {
                return $pengembalianData->get($date, 0);
            });
        }

        return view('home', compact(
            'events',
            'bookRecommendations',
            'principal',
            'totalBooks',
            'totalMembers',
            'activeBorrowings',
            'lateBorrowings',
            'todayAbsences',
            'absensiLabels',
            'absensiValues',
            'pengembalianLabels',
            'pengembalianValues',
            'chartFilter'
        ));
    }
}