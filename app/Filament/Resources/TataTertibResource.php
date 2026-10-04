<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TataTertibResource\Pages;
use App\Models\TataTertib;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TataTertibResource extends Resource
{
    protected static ?string $model = TataTertib::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Tata Tertib';
    
    protected static ?string $navigationGroup = 'Konten Website';
    protected static ?int $navigationSort = 43;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tata Tertib')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->maxLength(500),
                        
                        Forms\Components\FileUpload::make('pdf_file')
                            ->label('File PDF Tata Tertib')
                            ->required()
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('tata-tertib')
                            ->maxSize(5120) // 5MB
                            ->downloadable()
                            ->openable()
                            ->helperText('Upload file PDF maksimal 5MB'),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->helperText('Hanya 1 tata tertib yang aktif yang akan ditampilkan'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('pdf_file')
                    ->label('File PDF')
                    ->formatStateUsing(fn ($state) => basename($state))
                    ->limit(30),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
            'index' => Pages\ListTataTertibs::route('/'),
            'create' => Pages\CreateTataTertib::route('/create'),
            'edit' => Pages\EditTataTertib::route('/{record}/edit'),
        ];
    }
}