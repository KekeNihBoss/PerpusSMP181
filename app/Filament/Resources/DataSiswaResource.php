<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataSiswaResource\Pages;
use App\Filament\Resources\DataSiswaResource\RelationManagers;
use App\Models\DataSiswa;
use App\Filament\Exports\DataSiswaExporter;
use App\Filament\Imports\DataSiswaImporter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextEntry;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\TextFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ImportAction;

use Filament\Notifications\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class DataSiswaResource extends Resource
{
    protected static ?string $model = DataSiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $slug = 'DataSiswa';
    protected static ?int $navigationSort = 20;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Informasi Pribadi')
                ->description('Data identitas siswa')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            TextInput::make('nis')
                                ->label('NIS')
                                ->placeholder('Masukkan NIS Siswa')
                                ->prefixIcon('heroicon-o-identification')
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->columnSpan(1),

                            TextInput::make('nama')
                                ->label('Nama Lengkap')
                                ->placeholder('Masukkan Nama Lengkap Siswa')
                                ->prefixIcon('heroicon-o-user')
                                ->required()
                                ->columnSpan(1),
                        ]),

                    Forms\Components\Grid::make(2)
                        ->schema([
                            Select::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->placeholder('Pilih Jenis Kelamin')
                                ->prefixIcon('heroicon-o-user')
                                ->options([
                                    'L' => 'Laki - Laki',
                                    'P' => 'Perempuan'
                                ])
                                ->required()
                                ->columnSpan(1),

                            Select::make('kelas')
                                ->label('Kelas')
                                ->placeholder('Pilih Kelas')
                                ->prefixIcon('heroicon-o-academic-cap')
                                ->options([
                                    '7-A' => '7-A',
                                    '7-B' => '7-B',
                                    '7-C' => '7-C',
                                    '7-D' => '7-D',
                                    '7-E' => '7-E',
                                    '7-F' => '7-F',
                                    '8-A' => '8-A',
                                    '8-B' => '8-B',
                                    '8-C' => '8-C',
                                    '8-D' => '8-D',
                                    '8-E' => '8-E',
                                    '8-F' => '8-F',
                                    '9-A' => '9-A',
                                    '9-B' => '9-B',
                                    '9-C' => '9-C',
                                    '9-D' => '9-D',
                                    '9-E' => '9-E',
                                    '9-F' => '9-F',                    
                                ])
                                ->searchable()
                                ->required()
                                ->columnSpan(1),
                        ]),
                ]),

            Forms\Components\Section::make('Kontak & Alamat')
                ->description('Informasi kontak dan tempat tinggal')
                ->icon('heroicon-o-phone')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            TextInput::make('tlp')
                                ->label('Nomor Telepon')
                                ->placeholder('Contoh: 081234567890')
                                ->prefixIcon('heroicon-o-phone')
                                ->tel()
                                ->required()
                                ->helperText('Format: 08xx-xxxx-xxxx')
                                ->columnSpan(1),

                            TextInput::make('email')
                                ->label('Alamat Email')
                                ->placeholder('Masukkan Alamat Email')
                                ->prefixIcon('heroicon-o-envelope')
                                ->email()
                                ->columnSpan(1),
                            TextInput::make('alamat')
                                ->label('Alamat Lengkap')
                                ->placeholder('Masukkan Alamat Lengkap')
                                ->prefixIcon('heroicon-o-map-pin')
                                ->required()
                                ->columnSpan(1),
                        ]),
                ]),

            Forms\Components\Section::make('Foto Siswa')
                ->description('Upload foto profil siswa (JPG, PNG, atau WEBP)')
                ->icon('heroicon-o-camera')
                ->schema([
                    FileUpload::make('foto')
                        ->label('Foto Profil')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '1:1',
                        ])
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                        ->disk('public')
                        ->directory('foto')
                        ->preserveFilenames()
                        ->maxSize(2048)
                        ->helperText('Maksimal 2MB. Rekomendasi: Foto persegi (1:1)')
                        ->columnSpanFull(),
                ]),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->defaultSort('nama', 'asc')
        ->columns([
            ImageColumn::make('foto')
                ->label('Foto')
                ->circular()
                ->size(60),

            TextColumn::make('nis')
                ->label('NIS')
                ->icon('heroicon-o-identification')
                ->searchable()
                ->sortable()
                ->weight('semibold')
                ->copyable()
                ->copyMessage('NIS disalin!')
                ->copyMessageDuration(1500),

            TextColumn::make('nama')
                ->label('Nama')
                ->icon('heroicon-o-user')
                ->searchable()
                ->sortable()
                ->weight('bold'),

            TextColumn::make('kelas')
                ->label('Kelas')
                ->icon('heroicon-o-academic-cap')
                ->badge()
                ->color('info')
                ->sortable(),

            TextColumn::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->icon(fn ($record) => $record->jenis_kelamin === 'L' ? 'heroicon-o-user' : 'heroicon-o-user')
                ->badge()
                ->color(fn ($state) => $state === 'L' ? 'primary' : 'danger')
                ->sortable(),
            TextColumn::make('email')
                ->label('Email')
                ->icon('heroicon-o-envelope')
                ->sortable()
                ->searchable()
                ->wrap(),
            TextColumn::make('tlp')
                ->label('Nomor Telepon')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->iconColor('success')
                ->url(function ($record) {
                    // Bersihkan nomor dari karakter non-digit
                    $phone = preg_replace('/[^0-9]/', '', $record->tlp);
                    
                    // Kalau diawali 0, ganti jadi 62
                    if (substr($phone, 0, 1) === '0') {
                        $phone = '62' . substr($phone, 1);
                    }
                    
                    // Return WhatsApp URL
                    return 'https://wa.me/' . $phone;
                })
                ->openUrlInNewTab()
                ->tooltip('Klik untuk chat WhatsApp')
                ->weight('medium'),
            
            TextColumn::make('alamat')
                ->label('Alamat')
                ->icon('heroicon-o-map-pin')
                ->limit(40)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
                    if (strlen($state) > 40) {
                        return $state;
                    }
                    return null;
                })
                ->wrap(),
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
        
            Filter::make('alamat')
                ->form([
                    TextInput::make('alamat')
                        ->label('Alamat')
                        ->prefixIcon('heroicon-o-map-pin'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['alamat'], fn ($q, $alamat) => $q->where('alamat', 'like', "%{$alamat}%"));
                }),
            
            Filter::make('tlp')
                ->form([
                    TextInput::make('tlp')
                        ->label('Nomor Telepon')
                        ->prefixIcon('heroicon-o-phone'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['tlp'], fn ($q, $tlp) => $q->where('tlp', 'like', "%{$tlp}%"));
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
        
            SelectFilter::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan',
                ]),

        ], layout: FiltersLayout::Dropdown)
        ->filtersFormColumns(2)
        ->hiddenFilterIndicators()    

        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                ExportBulkAction::make()->exporter(DataSiswaExporter::class),
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
        ->headerActions([
            Action::make('import')
                ->label('Import Siswa')
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
                        // ->storeFiles(false),
                ])
                ->action(function (array $data) {
                    $file = $data['file'];
                    Excel::import(new SiswaImport, $file);

                    Notification::make()
                        ->title('Import data siswa berhasil!')
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
            'index' => Pages\ListDataSiswas::route('/'),
            'create' => Pages\CreateDataSiswa::route('/create'),
            'edit' => Pages\EditDataSiswa::route('/{record}/edit'),
        ];
    }
    
    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_data::siswa');
    }
}
