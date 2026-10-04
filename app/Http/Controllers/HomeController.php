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
        $chartFilter = $request->get('chart_filter', '7days') === 'month' ? 'month' : '7days';
        $days = $chartFilter === 'month' ? 30 : 7;

        [$absensiLabels, $absensiValues] = $this->dailyCounts(
            (new Absen())->getTable(), 'created_at', $days
        );
        [$pengembalianLabels, $pengembalianValues] = $this->dailyCounts(
            (new Peminjaman())->getTable(), 'updated_at', $days, ['status' => 'dikembalikan']
        );

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

    /**
     * Data grafik untuk AJAX (tanpa reload halaman).
     */
    public function chartData(Request $request)
    {
        $filter = $request->get('filter', '7days') === 'month' ? 'month' : '7days';
        $days = $filter === 'month' ? 30 : 7;

        [$absensiLabels, $absensiValues] = $this->dailyCounts(
            (new Absen())->getTable(), 'created_at', $days
        );
        [$pengembalianLabels, $pengembalianValues] = $this->dailyCounts(
            (new Peminjaman())->getTable(), 'updated_at', $days, ['status' => 'dikembalikan']
        );

        return response()->json([
            'filter'       => $filter,
            'absensi'      => ['labels' => $absensiLabels, 'values' => $absensiValues],
            'pengembalian' => ['labels' => $pengembalianLabels, 'values' => $pengembalianValues],
        ]);
    }

    /**
     * Hitung jumlah record per hari selama N hari terakhir (termasuk hari ini),
     * label tanggal tanpa data diisi 0.
     */
    private function dailyCounts(string $table, string $column, int $days, array $where = []): array
    {
        $rows = DB::table($table)
            ->selectRaw("DATE({$column}) as date, COUNT(*) as total")
            ->where($column, '>=', Carbon::now()->subDays($days - 1)->startOfDay())
            ->when($where, fn ($q) => $q->where($where))
            ->groupBy('date')
            ->pluck('total', 'date');

        $labels = collect();
        $values = collect();
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels->push(Carbon::parse($date)->format('d M'));
            $values->push((int) $rows->get($date, 0));
        }

        return [$labels, $values];
    }
}
