<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookRecommendationResource\Pages;
use App\Models\BookRecommendation;
use App\Models\DataBuku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookRecommendationResource extends Resource
{
    protected static ?string $model = BookRecommendation::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Rekomendasi Bacaan';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?int $navigationSort = 44;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('pilih_buku')
                ->label('Ambil dari Data Buku')
                ->placeholder('— Pilih buku untuk isi otomatis (opsional) —')
                ->options(function () {
                    return DataBuku::query()
                        ->orderBy('judul')
                        ->get()
                        ->mapWithKeys(fn ($buku) => [$buku->idbuku => "{$buku->judul} ({$buku->idbuku})"]);
                })
                ->searchable()
                ->reactive()
                ->dehydrated(false)
                ->afterStateUpdated(function ($state, callable $set) {
                    if (! $state) {
                        return;
                    }

                    $buku = DataBuku::where('idbuku', $state)->first();

                    if ($buku) {
                        $set('title', $buku->judul);
                        $set('author', $buku->penulis);
                        $set('category', $buku->kategori);
                        $set('year', $buku->tahunpembelian ?: null);
                        $set('cover', $buku->cover);
                    }
                })
                ->columnSpanFull(),

            Forms\Components\TextInput::make('title')
                ->label('Judul Buku')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('author')
                ->label('Penulis')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('category')
                ->label('Kategori')
                ->options(function () {
                    $fixed = ['Fiksi', 'Non-Fiksi', 'Sains', 'Sejarah', 'Biografi', 'Novel', 'Komik', 'Lainnya'];

                    return collect($fixed)
                        ->merge(DataBuku::pluck('kategori'))
                        ->filter()
                        ->unique()
                        ->values()
                        ->mapWithKeys(fn ($kategori) => [$kategori => $kategori]);
                })
                ->searchable(),

            Forms\Components\TextInput::make('year')
                ->label('Tahun Terbit')
                ->numeric()
                ->maxLength(4),

            Forms\Components\FileUpload::make('cover')
                ->label('Cover Buku')
                ->image()
                ->directory('books')
                ->imageEditor(),

            Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->required()
                ->rows(5)
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')
                ->label('Tampilkan di Website')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->label('Cover')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Penulis')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori'),
                    
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookRecommendations::route('/'),
            'create' => Pages\CreateBookRecommendation::route('/create'),
            'edit' => Pages\EditBookRecommendation::route('/{record}/edit'),
        ];
    }
}