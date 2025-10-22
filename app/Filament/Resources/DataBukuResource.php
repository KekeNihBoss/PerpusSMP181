<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataBukuResource\Pages;
use App\Filament\Resources\DataBukuResource\RelationManagers;
use App\Models\DataBuku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Route;

// Form
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataBukuImport;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\TextFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;

class DataBukuResource extends Resource
{
    protected static ?string $model = DataBuku::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Data';
    protected static ?string $slug = 'DataBuku';
    protected static ?int $navigationSort = 4;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas Buku')
                    ->description('Informasi dasar buku')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('idbuku')
                                    ->label('ID Buku')
                                    ->placeholder('Contoh: BK001')
                                    ->prefixIcon('heroicon-o-hashtag')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('judul')
                                    ->label('Judul Buku')
                                    ->placeholder('Masukkan Judul Buku')
                                    ->prefixIcon('heroicon-o-book-open')
                                    ->required()
                                    ->columnSpan(1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('penulis')
                                    ->label('Nama Penulis')
                                    ->placeholder('Masukkan Nama Penulis')
                                    ->prefixIcon('heroicon-o-pencil')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('penerbit')
                                    ->label('Penerbit')
                                    ->placeholder('Masukkan Nama Penerbit')
                                    ->prefixIcon('heroicon-o-building-office')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Kategori & Lokasi')
                    ->description('Klasifikasi dan penempatan buku')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('kategori')
                                    ->label('Kategori')
                                    ->placeholder('Contoh: Fiksi, Non-Fiksi')
                                    ->prefixIcon('heroicon-o-tag')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('nomorrak')
                                    ->label('Nomor Rak')
                                    ->placeholder('Contoh: A1, B2')
                                    ->prefixIcon('heroicon-o-archive-box')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('stokbuku')
                                    ->label('Stok Buku')
                                    ->placeholder('Jumlah buku')
                                    ->prefixIcon('heroicon-o-cube')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(1)
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Informasi Tambahan')
                    ->description('Data pelengkap buku')
                    ->icon('heroicon-o-calendar')
                    ->schema([
                        TextInput::make('tahunpembelian')
                            ->label('Tahun Pembelian')
                            ->placeholder('Contoh: 2024')
                            ->prefixIcon('heroicon-o-calendar')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y'))
                            ->default(date('Y'))
                            ->required()
                            ->helperText('Tahun saat buku dibeli/diterima perpustakaan'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('judul', 'asc')
            ->columns([
                TextColumn::make('idbuku')
                    ->label('ID Buku')
                    ->icon('heroicon-o-hashtag')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->copyable()
                    ->copyMessage('ID Buku disalin!')
                    ->copyMessageDuration(1500),

                TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->icon('heroicon-o-book-open')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 40) {
                            return $state;
                        }
                        return null;
                    })
                    ->description(fn ($record) => $record->penulis)
                    ->color('primary'),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->icon('heroicon-o-tag')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('stokbuku')
                    ->label('Stok')
                    ->icon('heroicon-o-cube')
                    ->badge()
                    ->color(fn($state) => $state > 5 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                    ->sortable()
                    ->url(fn($record) => url('/perpus/Peminjaman') . '?tableFilters[idbuku][idbuku]=' . urlencode($record->idbuku))
                    ->alignCenter(),

                TextColumn::make('nomorrak')
                    ->label('Rak')
                    ->icon('heroicon-o-archive-box')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('penerbit')
                    ->label('Penerbit')
                    ->icon('heroicon-o-building-office')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('penulis')
                    ->label('Penulis')
                    ->icon('heroicon-o-pencil')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tahunpembelian')
                    ->label('Tahun')
                    ->icon('heroicon-o-calendar')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('idbuku')
                    ->form([
                        TextInput::make('idbuku')
                            ->label('ID Buku')
                            ->prefixIcon('heroicon-o-hashtag'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['idbuku'], fn ($q, $idbuku) => $q->where('idbuku', 'like', "%{$idbuku}%"));
                    }),

                Filter::make('judul')
                    ->form([
                        TextInput::make('judul')
                            ->label('Judul Buku')
                            ->prefixIcon('heroicon-o-book-open'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['judul'], fn ($q, $judul) => $q->where('judul', 'like', "%{$judul}%"));
                    }),

                Filter::make('kategori')
                    ->form([
                        TextInput::make('kategori')
                            ->label('Kategori')
                            ->prefixIcon('heroicon-o-tag'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['kategori'], fn ($q, $kategori) => $q->where('kategori', 'like', "%{$kategori}%"));
                    }),
                
                Filter::make('stokbuku')
                    ->form([
                        TextInput::make('stokbuku')
                            ->label('Stok Buku')
                            ->prefixIcon('heroicon-o-cube')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['stokbuku'], fn ($q, $stokbuku) => $q->where('stokbuku', '>=', $stokbuku));
                    }),

                Filter::make('nomorrak')
                    ->form([
                        TextInput::make('nomorrak')
                            ->label('Nomor Rak')
                            ->prefixIcon('heroicon-o-archive-box'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['nomorrak'], fn ($q, $nomorrak) => $q->where('nomorrak', 'like', "%{$nomorrak}%"));
                    }),
        
                Filter::make('penerbit')
                    ->form([
                        TextInput::make('penerbit')
                            ->label('Penerbit')
                            ->prefixIcon('heroicon-o-building-office'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['penerbit'], fn ($q, $penerbit) => $q->where('penerbit', 'like', "%{$penerbit}%"));
                    }),

                Filter::make('penulis')
                    ->form([
                        TextInput::make('penulis')
                            ->label('Penulis')
                            ->prefixIcon('heroicon-o-pencil'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['penulis'], fn ($q, $penulis) => $q->where('penulis', 'like', "%{$penulis}%"));
                    }),

                Filter::make('tahunpembelian')
                    ->form([
                        TextInput::make('tahunpembelian')
                            ->label('Tahun Pembelian')
                            ->prefixIcon('heroicon-o-calendar')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['tahunpembelian'], fn ($q, $tahunpembelian) => $q->where('tahunpembelian', '=', $tahunpembelian));
                    }),
        
            ], layout: FiltersLayout::Dropdown)
            ->filtersFormColumns(2)
            ->hiddenFilterIndicators() 

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Action::make('import')
                    ->label('Import Buku')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('file')
                            ->label('Pilih File Excel')
                            ->acceptedFileTypes([
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-excel',
                                'text/csv',
                            ])
                            ->required()
                            ->storeFiles(false),
                    ])
                    ->action(function (array $data) {
                        $file = $data['file'];
                        Excel::import(new DataBukuImport, $file);

                        Notification::make()
                            ->title('Import berhasil!')
                            ->success()
                            ->send();
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
            'index' => Pages\ListDataBukus::route('/'),
            'create' => Pages\CreateDataBuku::route('/create'),
            'edit' => Pages\EditDataBuku::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_data::buku');
    }
}