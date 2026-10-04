<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengembalianResource\Pages;
use App\Filament\Resources\PengembalianResource\RelationManagers;
use App\Models\Pengembalian;
use App\Filament\Exports\PengembalianExporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBiulder\Constraints\TextConstraints;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengembalianExport;

use Filament\Tables\Actions\ActionGroup;

class PengembalianResource extends Resource
{
    protected static ?string $model = Pengembalian::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Sirkulasi Buku';
    protected static ?string $slug = 'Pengembalian';
    protected static ?int $navigationSort = 31;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_kembali', 'desc') // Terbaru dulu
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

                TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->icon('heroicon-o-check-circle')
                    ->date('d/m/Y')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                Filter::make('nis')
                    ->form([
                        TextInput::make('nis')
                            ->label('NIS')
                            ->prefixIcon('heroicon-o-identification'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['nis'], fn ($q, $nis) => $q->where('nis', 'like', "%{$nis}%"));
                    }),

                Filter::make('nama')
                    ->form([
                        TextInput::make('nama')
                            ->label('Nama')
                            ->prefixIcon('heroicon-o-user'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query 
                            ->when($data['nama'], fn ($q, $nama) => $q->where('nama', 'like', "%{$nama}%"));
                    }),

                Filter::make('idbuku')
                    ->form([
                        TextInput::make('idbuku')
                            ->label('ID Buku')
                            ->prefixIcon('heroicon-o-hashtag'),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        return $query 
                            ->when($data['idbuku'], fn ($q, $idbuku) => $q->where('idbuku', 'like', "%{$idbuku}%"));
                    }),

                Filter::make('namabuku')
                    ->form([
                        TextInput::make('namabuku')
                            ->label('Nama Buku')
                            ->prefixIcon('heroicon-o-book-open'),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        return $query
                            ->when($data['namabuku'], fn ($q, $namabuku) => $q->where('namabuku', 'like', "%{$namabuku}%"));
                    }),

                Filter::make('tanggal_pinjam')
                    ->form([
                        DatePicker::make('tanggal_pinjam')
                            ->label('Tanggal Pinjam')
                            ->prefixIcon('heroicon-o-calendar'),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        return $query 
                            ->when($data['tanggal_pinjam'], fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pinjam', '>=', $date));
                    }),

                Filter::make('tanggal_kembali')
                    ->form([
                        DatePicker::make('tanggal_kembali')
                            ->label('Tanggal Kembali')
                            ->prefixIcon('heroicon-o-check-circle'),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        return $query 
                            ->when($data['tanggal_kembali'], fn (Builder $query, $date): Builder => $query->whereDate('tanggal_kembali', '>=', $date));
                    }),

                SelectFilter::make('kelas')
                    ->label('Kelas')
                    ->options([
                        '7-A' => '7-A', '7-B' => '7-B', '7-C' => '7-C', '7-D' => '7-D',
                        '7-E' => '7-E', '7-F' => '7-F',
                        '8-A' => '8-A', '8-B' => '8-B', '8-C' => '8-C', '8-D' => '8-D',
                        '8-E' => '8-E', '8-F' => '8-F',
                        '9-A' => '9-A', '9-B' => '9-B', '9-C' => '9-C', '9-D' => '9-D',
                        '9-E' => '9-E', '9-F' => '9-F',
                    ]),
            ], layout: FiltersLayout::Dropdown)
            ->filtersFormColumns(2) // Filter dalam 2 kolom
            ->hiddenFilterIndicators()
        
            ->actions([
                // ⭐ TIDAK ADA ACTION (Read-only)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // ⭐ HANYA DELETE (Tidak ada edit)
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            
            ->headerActions([
                Action::make('exportPerBulan')
                    ->label('Per Bulan')
                    ->icon('heroicon-o-calendar-days')
                    ->color('warning')
                    ->form([
                        Forms\Components\Select::make('bulan')
                            ->label('Bulan')
                            ->options([
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric()
                            ->default(date('Y'))
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $bulan = $data['bulan'];
                        $tahun = $data['tahun'];

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\PengembalianExport($bulan, $tahun),
                            "pengembalian-{$bulan}-{$tahun}.xlsx"
                        );
                    }),

                Action::make('exportPerTahun')
                    ->label('Per Tahun')
                    ->icon('heroicon-o-calendar')
                    ->color('info')
                    ->form([
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100)
                            ->default(date('Y'))
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $tahun = $data['tahun'];

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\PengembalianExport(null, $tahun),
                            "pengembalian-{$tahun}.xlsx"
                        );
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengembalians::route('/'),
            // ⭐ TIDAK ADA CREATE & EDIT (Read-only)
        ];
    }

    // ⭐ Disable semua kemampuan create & edit
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_pengembalian');
    }
}