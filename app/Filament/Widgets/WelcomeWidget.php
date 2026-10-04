<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.welcome-widget';

    public function getGreeting(): string
    {
        $hour = now()->hour;

        return match (true) {
            $hour < 11 => 'Selamat Pagi',
            $hour < 15 => 'Selamat Siang',
            $hour < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
        };
    }

    public function getQuotes(): array
    {
        return [
            'Semangat menjalani hari ini!',
            'Selamat datang kembali!',
            'Jadikan hari ini produktif!',
            'Setiap buku punya cerita.',
            'Belajar tanpa henti!',
            'Kamu hebat hari ini!',
            'Keep up the great work!',
            'Buku adalah jendela dunia.',
            'Senyum dulu sebelum mulai.',
            'Ilmu yang bermanfaat abadi.',
        ];
    }
}
