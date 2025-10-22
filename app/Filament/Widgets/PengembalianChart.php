<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Pengembalian;
use Carbon\Carbon;

class PengembalianChart extends ChartWidget
{
    protected static ?string $heading = '📚 Grafik Pengembalian Buku';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getFilters(): ?array 
    {
        return [
            'daily' => 'Per Hari',
            'monthly' => 'Per Bulan',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'daily'; 
        if ($filter === 'monthly') {
            return $this->getMonthlyData();
        }

        return $this->getDailyData();
    }

    protected function getDailyData(): array
    {
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        $trendMale = Trend::query(Pengembalian::query()->whereHas('siswa', fn($q) => $q->where('jenis_kelamin', 'L')))
            ->between(start: $start, end: $end)
            ->perDay()
            ->count();

        $trendFemale = Trend::query(Pengembalian::query()->whereHas('siswa', fn($q) => $q->where('jenis_kelamin', 'P')))
            ->between(start: $start, end: $end)
            ->perDay()
            ->count();

        $labels = $trendMale->map(fn(TrendValue $v) => Carbon::parse($v->date)->format('d M'))->toArray();

        return [
            'datasets' => [
                [
                    'label'           => '👨 Laki-Laki',
                    'data'            => $trendMale->map(fn(TrendValue $v) => $v->aggregate)->toArray(),
                    'borderColor'     => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointRadius'     => 4,
                    'pointHoverRadius' => 6,
                ],
                [
                    'label'           => '👩 Perempuan',
                    'data'            => $trendFemale->map(fn(TrendValue $v) => $v->aggregate)->toArray(),
                    'borderColor'     => '#ec4899',
                    'backgroundColor' => 'rgba(236, 72, 153, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointRadius'     => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getMonthlyData(): array
    {
        $start = Carbon::now()->startOfYear();
        $end   = Carbon::now()->endOfYear();

        $trendMale = Trend::query(Pengembalian::query()->whereHas('siswa', fn($q) => $q->where('jenis_kelamin', 'L')))
            ->between(start: $start, end: $end)
            ->perMonth()
            ->count();

        $trendFemale = Trend::query(Pengembalian::query()->whereHas('siswa', fn($q) => $q->where('jenis_kelamin', 'P')))
            ->between(start: $start, end: $end)
            ->perMonth()
            ->count();

        $labels = $trendMale->map(fn(TrendValue $v) => Carbon::parse($v->date)->format('M Y'))->toArray();

        return [
            'datasets' => [
                [
                    'label'           => '👨 Laki-Laki',
                    'data'            => $trendMale->map(fn(TrendValue $v) => $v->aggregate)->toArray(),
                    'borderColor'     => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointRadius'     => 4,
                    'pointHoverRadius' => 6,
                ],
                [
                    'label'           => '👩 Perempuan',
                    'data'            => $trendFemale->map(fn(TrendValue $v) => $v->aggregate)->toArray(),
                    'borderColor'     => '#ec4899',
                    'backgroundColor' => 'rgba(236, 72, 153, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.4,
                    'pointRadius'     => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}