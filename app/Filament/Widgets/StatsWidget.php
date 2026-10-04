<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Absen;
use App\Models\DataBuku;
use App\Models\Peminjaman;

class StatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $quotes = [
            'Semangat menjalani hari ini! ✨',
            'Selamat datang kembali! 👋',
            'Jadikan hari ini produktif! 💪',
            'Setiap buku punya cerita 📖',
            'Belajar tanpa henti! 🎓',
            'Kamu hebat hari ini! 🌟',
            'Keep up the great work! 🚀',
            'Buku adalah jendela dunia 🌍',
            'Senyum dulu sebelum mulai 😊',
            'Ilmu yang bermanfaat abadi 📚',
        ];

        $randomQuote = $quotes[array_rand($quotes)];
        $userName = auth()->user()->name ?? 'Guest';

        // Hitung total buku
        $totalBuku = DataBuku::count();
        $bukuDipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $bukuTersedia = $totalBuku - $bukuDipinjam;

        return [
            // Card 1: Absen Hari Ini
            Stat::make('Absen Hari Ini', Absen::whereDate('tanggal', now())->count())
                ->description('Pengunjung hari ini')
                ->descriptionIcon('heroicon-o-users')
                ->icon('heroicon-o-clipboard-document-check')
                ->color('success')
                ->chart([7, 12, 15, 20, 18, 25, 30]),
            
            // Card 2: Welcome Message (Tengah)
            Stat::make('Selamat Datang, ' . $userName, $randomQuote)
                ->description('Dashboard Perpustakaan Sekolah')
                ->descriptionIcon('heroicon-o-sparkles')
                ->icon('heroicon-o-hand-raised')
                ->color('info'),

            // Card 3: Total Buku
            Stat::make('Total Buku Perpustakaan', $totalBuku)
                ->description($bukuTersedia . ' tersedia · ' . $bukuDipinjam . ' dipinjam')
                ->descriptionIcon('heroicon-o-book-open')
                ->icon('heroicon-o-square-3-stack-3d')
                ->color('warning')
                ->chart([50, 55, 60, 65, 70, 75, 78]),
        ];
    }
}