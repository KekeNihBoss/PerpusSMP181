<?php

namespace App\Filament\Widgets;

use App\Models\Peminjaman;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;

class LateLoansWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Peminjaman::query()
                    ->where('status', 'Dipinjam')
                    ->whereDate('tanggal_tenggat', '<', now())
                    ->latest('tanggal_tenggat')
                    ->limit(5)
            )
            ->heading('Peminjaman Terlambat — Butuh Perhatian')
            ->description('Daftar peminjaman yang sudah melewati batas waktu pengembalian')
            ->emptyStateHeading('Tidak ada peminjaman terlambat')
            ->emptyStateDescription('Semua peminjaman masih dalam batas waktu atau sudah dikembalikan.')
            ->columns([
                TextColumn::make('nis')
                    ->label('NIS')
                    ->icon('heroicon-o-identification')
                    ->searchable(),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->badge()
                    ->color('info'),

                TextColumn::make('namabuku')
                    ->label('Judul Buku')
                    ->icon('heroicon-o-book-open')
                    ->limit(30)
                    ->tooltip(fn ($record): ?string => strlen($record->namabuku) > 30 ? $record->namabuku : null),

                TextColumn::make('tanggal_tenggat')
                    ->label('Jatuh Tempo')
                    ->date('d/m/Y')
                    ->icon('heroicon-o-clock')
                    ->color('danger'),

                TextColumn::make('terlambat')
                    ->label('Keterlambatan')
                    ->badge()
                    ->color('danger')
                    ->getStateUsing(fn ($record) => round(abs(now()->diffInDays(Carbon::parse($record->tanggal_tenggat)))) . ' hari'),
            ])
            ->actions([
                Tables\Actions\Action::make('chat')
                    ->label('Chat')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('danger')
                    ->url(function (Peminjaman $record) {
                        $siswa = \App\Models\DataSiswa::where('nis', $record->nis)->first();

                        if ($siswa && $siswa->tlp) {
                            $phone = preg_replace('/[^0-9]/', '', $siswa->tlp);

                            if (substr($phone, 0, 1) === '0') {
                                $phone = '62' . substr($phone, 1);
                            }

                            $message = "Halo {$record->nama}, buku *{$record->namabuku}* yang kamu pinjam sudah melewati batas waktu pengembalian. Mohon segera dikembalikan ya. Terima kasih!";

                            return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
                        }

                        return null;
                    })
                    ->openUrlInNewTab(),
            ]);
    }
}
