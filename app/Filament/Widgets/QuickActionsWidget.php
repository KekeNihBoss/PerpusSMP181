<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.quick-actions';

    protected function getViewData(): array
    {
        return [
            'actions' => $this->getActions(),
        ];
    }

    public function getActions(): array
    {
        $user = auth()->user();

        return [
            [
                'label' => 'Absen Pengunjung',
                'description' => 'Catat kehadiran siswa di perpustakaan',
                'icon' => 'heroicon-o-clipboard-document-check',
                'color' => 'success',
                'url' => \App\Filament\Resources\AbsenResource::getUrl('create'),
                'visible' => $user->can('create_absen'),
            ],
            [
                'label' => 'Tambah Peminjaman',
                'description' => 'Buat catatan peminjaman buku baru',
                'icon' => 'heroicon-o-arrow-up-tray',
                'color' => 'warning',
                'url' => \App\Filament\Resources\PeminjamanResource::getUrl('create'),
                'visible' => $user->can('create_peminjaman'),
            ],
            [
                'label' => 'Data Buku',
                'description' => 'Kelola koleksi buku perpustakaan',
                'icon' => 'heroicon-o-book-open',
                'color' => 'info',
                'url' => \App\Filament\Resources\DataBukuResource::getUrl('index'),
                'visible' => $user->can('view_any_data::buku') || $user->can('view_data::buku'),
            ],
            [
                'label' => 'Rekomendasi Bacaan',
                'description' => 'Atur buku rekomendasi untuk website',
                'icon' => 'heroicon-o-star',
                'color' => 'primary',
                'url' => \App\Filament\Resources\BookRecommendationResource::getUrl('index'),
                'visible' => $user->can('view_any_book_recommendation') || $user->can('view_book_recommendation'),
            ],
            [
                'label' => 'Template Import Buku',
                'description' => 'Unduh template Excel pengisian data buku',
                'icon' => 'heroicon-o-arrow-down-tray',
                'color' => 'danger',
                'url' => route('templates.buku'),
                'download' => true,
                'visible' => $user->can('create_data::buku'),
            ],
            [
                'label' => 'Template Import Siswa',
                'description' => 'Unduh template Excel pengisian data siswa',
                'icon' => 'heroicon-o-arrow-down-tray',
                'color' => 'danger',
                'url' => route('templates.siswa'),
                'download' => true,
                'visible' => $user->can('create_data::siswa'),
            ],
        ];
    }
}
