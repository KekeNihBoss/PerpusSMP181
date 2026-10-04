<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DataSiswa;
use App\Models\DataBuku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Carbon\Carbon;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationGroup = 'Sirkulasi Buku';
    protected static ?string $slug = 'Peminjaman';
    protected static ?string $navigationBadgeTooltip = 'Total Peminjaman';
    protected static ?int $navigationSort = 30;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Grid::make(2)
                ->schema([
                    Section::make('Data Siswa')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Select::make('nis')
                                ->label('NIS')
                                ->options(DataSiswa::all()->pluck('nis', 'nis'))
                                ->searchable()
                                ->reactive()
                                ->prefixIcon('heroicon-o-identification')
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $siswa = DataSiswa::where('nis', $state)->first();
                                        if ($siswa) {
                                            $set('nama', $siswa->nama);
                                            $set('kelas', $siswa->kelas);
                                        }
                                    }
                                })
                                ->required(),

                            TextInput::make('nama')
                                ->label('Nama')
                                ->disabled()
                                ->dehydrated()
                                ->prefixIcon('heroicon-o-user-circle'),

                            TextInput::make('kelas')
                                ->label('Kelas')
                                ->disabled()
                                ->dehydrated()
                                ->prefixIcon('heroicon-o-academic-cap'),
                        ])
                        ->columnSpan(1),

                    Section::make('Data Buku')
                        ->icon('heroicon-o-book-open')
                        ->schema([
                            Select::make('idbuku')
                                ->label('ID Buku')
                                ->options(DataBuku::where('stokbuku', '>', 0)->pluck('idbuku', 'idbuku'))
                                ->searchable()
                                ->reactive()
                                ->prefixIcon('heroicon-o-hashtag')
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state) {
                                        $buku = DataBuku::where('idbuku', $state)->first();
                                        if ($buku) {
                                            $set('namabuku', $buku->judul);
                                            $set('stok_tersedia', $buku->stokbuku);
                                        }
                                    } else {
                                        $set('namabuku', null);
                                        $set('stok_tersedia', null);
                                    }
                                })
                                ->required(),
                            TextInput::make('namabuku')
                                ->label('Judul Buku')
                                ->disabled()
                                ->dehydrated()
                                ->prefixIcon('heroicon-o-book-open'),
                            TextInput::make('stok_tersedia')
                                ->label('Stok Tersedia')
                                ->disabled()
                                ->dehydrated(false)
                                ->prefixIcon('heroicon-o-cube')
                        ])
                        ->columnSpan(1),
                ]),
            Section::make('Tanggal Peminjaman')
                ->icon('heroicon-o-calendar')
                ->schema([
                    DatePicker::make('tanggal_pinjam')
                        ->label('Tanggal Pinjam')
                        ->default(now())
                        ->displayFormat('d/m/Y')
                        ->prefixIcon('heroicon-o-calendar-days')
                        ->required(),
                ]),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->defaultSort(function (Builder $query) {
            // Custom sorting: Terlambat > Dipinjam > Dikembalikan
            $query->orderByRaw("
                CASE 
                    WHEN status = 'Dipinjam' AND tanggal_tenggat < NOW() THEN 1
                    WHEN status = 'Dipinjam' THEN 2
                    WHEN status = 'Dikembalikan' THEN 3
                    ELSE 4
                END
            ");
        })
        ->columns([
            TextColumn::make('nis')
                ->label('NIS')
                ->icon('heroicon-o-identification')
                ->searchable()
                ->sortable(),

            TextColumn::make('nama')
                ->label('Nama')
                ->icon('heroicon-o-user')
                ->searchable()
                ->sortable()
                ->weight('medium'),

            TextColumn::make('kelas')
                ->label('Kelas')
                ->icon('heroicon-o-academic-cap')
                ->badge()
                ->color('info')
                ->sortable(),

            TextColumn::make('idbuku')
                ->label('ID Buku')
                ->icon('heroicon-o-hashtag')
                ->searchable()
                ->sortable(),

            TextColumn::make('namabuku')
                ->label('Nama Buku')
                ->icon('heroicon-o-book-open')
                ->searchable()
                ->sortable()
                ->limit(30)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
                    if (strlen($state) > 30) {
                        return $state;
                    }
                    return null;
                }),

            TextColumn::make('tanggal_pinjam')
                ->label('Tanggal Pinjam')
                ->icon('heroicon-o-calendar')
                ->date('d/m/Y')
                ->sortable(),

            TextColumn::make('tanggal_tenggat')
                ->label('Tenggat')
                ->icon('heroicon-o-clock')
                ->date('d/m/Y')
                ->sortable()
                ->color(function ($record) {
                    // Merah kalau sudah lewat tenggat
                    if (now()->gt(Carbon::parse($record->tanggal_tenggat)) && $record->status === 'Dipinjam') {
                        return 'danger';
                    }
                    // Warning kalau kurang 2 hari lagi
                    if (abs(now()->diffInDays(Carbon::parse($record->tanggal_tenggat))) <= 2 && $record->status === 'Dipinjam') {
                        return 'warning';
                    }
                    return 'gray';
                }),

            TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(function ($state, $record) {
                    // Cek kalau terlambat
                    if ($record->status === 'Dipinjam' && now()->gt(Carbon::parse($record->tanggal_tenggat))) {
                        return 'Terlambat';
                    }
                    return $record->status;
                })
                ->icon(function ($state, $record) {
                    // Cek kalau terlambat
                    if ($record->status === 'Terlambat') {
                        return 'heroicon-o-exclamation-triangle';
                    }
                    if ($record->status === 'Dipinjam') {
                        return 'heroicon-o-arrow-up-tray';
                    }
                    return 'heroicon-o-check-circle';
                })
                ->colors([
                    'danger' => function($state, $record) {
                        // Terlambat = merah
                        return $record->status === 'Terlambat';
                    },
                    'warning' => function($state, $record) {
                        // Dipinjam tapi belum terlambat = kuning
                        return $record->status === 'Dipinjam' && now()->lte(Carbon::parse($record->tanggal_tenggat));
                    },
                    'success' => fn($state) => $state === 'Dikembalikan',
                ])
                ->sortable(),
        ])
        ->filters([
            Filter::make('nis')
                ->form([TextInput::make('nis')->label('NIS')->prefixIcon('heroicon-o-identification')])
                ->query(fn(Builder $query, array $data): Builder =>
                    $query->when($data['nis'], fn($q, $nis) => $q->where('nis', 'like', "%{$nis}%"))
                ),
            
            Filter::make('nama')
                ->form([TextInput::make('nama')->label('Nama')->prefixIcon('heroicon-o-user')])
                ->query(fn(Builder $query, array $data): Builder =>
                    $query->when($data['nama'], fn($q, $nama) => $q->where('nama', 'like', "%{$nama}%"))
                ),
            
            Filter::make('idbuku')
                ->form([TextInput::make('idbuku')->label('ID Buku')->prefixIcon('heroicon-o-hashtag')])
                ->query(fn(Builder $query, array $data): Builder =>
                    $query->when($data['idbuku'], fn($q, $idbuku) => $q->where('idbuku', 'like', "%{$idbuku}%"))
                ),

            Filter::make('namabuku')
                ->form([TextInput::make('namabuku')->label('Nama Buku')->prefixIcon('heroicon-o-book-open')])
                ->query(fn(Builder $query, array $data): Builder =>
                    $query->when($data['namabuku'], fn($q, $namabuku) => $q->where('namabuku', 'like', "%{$namabuku}%"))
                ),

            SelectFilter::make('kelas')
                ->label('Kelas')
                ->options([
                    '7-A' => '7-A', '7-B' => '7-B', '7-C' => '7-C',
                    '8-A' => '8-A', '8-B' => '8-B', '8-C' => '8-C',
                    '9-A' => '9-A', '9-B' => '9-B', '9-C' => '9-C',
                ]),

            SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'Dipinjam' => 'Dipinjam',
                    'Terlambat' => 'Terlambat',
                    'Dikembalikan' => 'Dikembalikan',
                ]),
        ], layout: FiltersLayout::Dropdown)
        ->filtersFormColumns(2) // Filter dalam 2 kolom
        ->actions([
            // Tombol Chat Peminjam untuk yang Terlambat dan belum dikembalikan
            Tables\Actions\Action::make('ChatPeminjam')
                ->label('Chat Peminjam')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('danger')
                ->url(function (Peminjaman $record) {
                    $siswa = DataSiswa::where('nis', $record->nis)->first();

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
                ->openUrlInNewTab()
                ->visible(function (Peminjaman $record): bool {
                    return $record->status === 'Terlambat'
                        && $record->getRawOriginal('status') !== 'Dikembalikan';
                }),

            // Tombol Kembalikan untuk yang masih Dipinjam atau Terlambat
            Tables\Actions\Action::make('Kembalikan')
                ->label(function (Peminjaman $record): string {
                    return $record->status === 'Terlambat' ? 'DiKembalikan' : 'Kembalikan';
                })
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function (Peminjaman $record) {
                    Pengembalian::create([
                        'nis' => $record->nis,
                        'nama' => $record->nama,
                        'kelas' => $record->kelas,
                        'idbuku' => $record->idbuku,
                        'namabuku' => $record->namabuku,
                        'tanggal_pinjam' => $record->tanggal_pinjam,
                        'tanggal_kembali' => now(),
                    ]);

                    $record->update(['status' => 'Dikembalikan']);

                    // Tambah stok buku kembali
                    $buku = DataBuku::where('idbuku', $record->idbuku)->first();
                    if ($buku) {
                        $buku->increment('stokbuku');
                    }
                })
                ->requiresConfirmation()
                ->modalHeading(fn (Peminjaman $record): string => $record->status === 'Terlambat' ? 'Kembalikan Buku (Terlambat)' : 'Kembalikan Buku')
                ->modalDescription(fn (Peminjaman $record): string => $record->status === 'Terlambat'
                    ? 'Peminjaman ini terlambat. Yakin buku sudah diterima dan ingin menandai sebagai dikembalikan?'
                    : 'Yakin buku sudah diterima dan ingin menandai sebagai dikembalikan?')
                ->color(function (Peminjaman $record): string {
                    return $record->status === 'Terlambat' ? 'warning' : 'success';
                })
                ->visible(function (Peminjaman $record): bool {
                    return $record->status !== 'Dikembalikan';
                }),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
}

    public static function getRelations(): array {
        return [];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            // 'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool {
        return auth()->user()->can('view_peminjaman');
    }
}
