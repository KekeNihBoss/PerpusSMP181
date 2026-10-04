<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Absen;
use Carbon\Carbon;

class AbsenChart extends ChartWidget
{
    protected static ?string $heading = '📊 Grafik Absensi Pengunjung';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';

    protected function getFilters(): ?array
    {
        return [
            'monthly' => 'Per Bulan',
            'yearly'  => 'Per Tahun',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'monthly';

        if ($filter === 'yearly') {
            return $this->getYearlyData();
        }

        return $this->getMonthlyData();
    }

    private function getStartYear(): int
    {
        $min = Absen::min('tanggal');

        return $min ? Carbon::parse($min)->year : (int) date('Y');
    }

    private function getMonthlyData(): array
    {
        $start = Carbon::now()->startOfYear();
        $end   = Carbon::now()->endOfYear();

        [$trendMale, $trendFemale] = $this->trends($start, $end, 'perMonth');

        return [
            'datasets' => [
                $this->dataset('👨 Laki-Laki', $trendMale, '#3b82f6', 'rgba(59, 130, 246, 0.1)'),
                $this->dataset('👩 Perempuan', $trendFemale, '#ec4899', 'rgba(236, 72, 153, 0.1)'),
            ],
            'labels' => $trendMale->map(fn (TrendValue $v) => Carbon::parse($v->date)->translatedFormat('M'))->toArray(),
        ];
    }

    private function getYearlyData(): array
    {
        $start = Carbon::create($this->getStartYear())->startOfYear();
        $end   = Carbon::now()->endOfYear();

        [$trendMale, $trendFemale] = $this->trends($start, $end, 'perYear');

        return [
            'datasets' => [
                $this->dataset('👨 Laki-Laki', $trendMale, '#3b82f6', 'rgba(59, 130, 246, 0.1)'),
                $this->dataset('👩 Perempuan', $trendFemale, '#ec4899', 'rgba(236, 72, 153, 0.1)'),
            ],
            'labels' => $trendMale->map(fn (TrendValue $v) => Carbon::parse($v->date)->format('Y'))->toArray(),
        ];
    }

    private function trends(Carbon $start, Carbon $end, string $interval): array
    {
        $trendMale = Trend::query(Absen::query()->whereHas('siswa', fn ($q) => $q->where('jenis_kelamin', 'L')))
            ->dateColumn('tanggal')
            ->between(start: $start, end: $end)
            ->{$interval}()
            ->count();

        $trendFemale = Trend::query(Absen::query()->whereHas('siswa', fn ($q) => $q->where('jenis_kelamin', 'P')))
            ->dateColumn('tanggal')
            ->between(start: $start, end: $end)
            ->{$interval}()
            ->count();

        return [$trendMale, $trendFemale];
    }

    private function dataset(string $label, $trend, string $border, string $background): array
    {
        return [
            'label'            => $label,
            'data'             => $trend->map(fn (TrendValue $v) => $v->aggregate)->toArray(),
            'borderColor'      => $border,
            'backgroundColor'  => $background,
            'fill'             => true,
            'tension'          => 0.4,
            'pointRadius'      => 4,
            'pointHoverRadius' => 6,
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
