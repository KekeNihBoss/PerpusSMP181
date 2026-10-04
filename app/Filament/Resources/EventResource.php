<?php

namespace App\Filament\Resources;

use App\Models\Event;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?int $navigationSort = 45;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Informasi Utama')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'Events' => 'Events',
                            'Blog' => 'Blog',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('author')
                        ->label('Penulis')
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('event_date')
                        ->label('Tanggal Event'),

                    Forms\Components\TextInput::make('location')
                        ->label('Lokasi'),
                ]),

            Forms\Components\Section::make('Konten')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi Singkat')
                        ->rows(3),

Forms\Components\RichEditor::make('content')
    ->label('Isi Konten')
    ->fileAttachmentsDisk('public')
    ->fileAttachmentsDirectory('events/content-images')
    ->maxLength(65535)
    ->columnSpanFull(),

                ]),

            Forms\Components\Section::make('Media')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Thumbnail')
                        ->directory('events')
                        ->image()
                        ->imagePreviewHeight('200'),
                ]),

            Forms\Components\Toggle::make('is_active')
                ->label('Tampilkan di Halaman')
                ->default(true)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->square(),

                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),

                Tables\Columns\TextColumn::make('category')->sortable(),

                Tables\Columns\TextColumn::make('views')->label('Dilihat'),

                Tables\Columns\ToggleColumn::make('is_active')->label('Aktif'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => EventResource\Pages\ListEvents::route('/'),
            'create' => EventResource\Pages\CreateEvent::route('/create'),
            'edit' => EventResource\Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
