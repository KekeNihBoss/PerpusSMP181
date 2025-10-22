<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenResource\Pages;
use App\Filament\Resources\AbsenResource\RelationManagers;
use App\Filament\Exports\AbsenExporter;
use App\Models\Absen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBiulder\Constraints\TextConstraints;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsenExport;

class AbsenResource extends Resource
{
    protected static ?string $model = Absen::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Absen Pengunjung';

    protected static ?string $slug = 'Absen';

    public static ?string $label = 'Absen Pengunjung';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('nis')
                    ->label('NIS')
                    ->placeholder('Cari berdasarkan NIS...')
                    ->options(\App\Models\DataSiswa::all()->pluck('nis', 'nis'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $siswa = \App\Models\DataSiswa::where('nis', $state)->first();
                            if ($siswa) {
                                $set('nama', $siswa->nama);
                                $set('kelas', $siswa->kelas);
                                $set('jenis_kelamin', $siswa->jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan');
                            }
                        }
                    })
                    ->required()
                    ->prefixIcon('heroicon-o-identification'),

                TextInput::make('nama')
                    ->label('Nama')
                    ->disabled()
                    ->dehydrated()
                    ->prefixIcon('heroicon-o-user'),

                TextInput::make('kelas')
                    ->label('Kelas')
                    ->disabled()
                    ->dehydrated()
                    ->prefixIcon('heroicon-o-academic-cap'),

                TextInput::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->disabled()
                    ->dehydrated()
                    ->prefixIcon('heroicon-o-user'),

                DatePicker::make('tanggal')
                    ->label('Tanggal Absen')
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->prefixIcon('heroicon-o-calendar')
                    ->helperText('Gunakan format Bulan/Hari/Tahun — contoh: 10/04/2025')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nis')
                    ->icon('heroicon-o-identification')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('NIS disalin!')
                    ->weight('semibold'),

                TextColumn::make('nama')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('kelas')
                    ->icon('heroicon-o-academic-cap')
                    ->badge()
                    ->color(fn (string $state): string => match (substr($state, 0, 1)) {
                        '7' => 'success',
                        '8' => 'warning',
                        '9' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('jenis_kelamin')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Laki-Laki' => 'primary',
                        'Perempuan' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('tanggal')
                    ->date('d-m-Y')
                    ->icon('heroicon-o-calendar')
                    ->sortable(),
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

                Filter::make('tanggal')
                    ->form([
                        TextInput::make('tanggal')
                            ->label('Tanggal')
                            ->prefixIcon('heroicon-o-calendar'),
                    ])
                    ->query(function (Builder $query, array $data): Builder{
                        return $query
                            ->when($data['tanggal'], fn ($q, $tanggal) => $q->where('tanggal', 'like', "%{$tanggal}%"));
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
                        'Laki-Laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan'
                    ])
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
                Action::make('exportPerBulan')
                    ->label('Export Per Bulan')
                    ->icon('heroicon-o-calendar')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('month')
                            ->label('Bulan')
                            ->options([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->default(now()->year)
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        return Excel::download(
                            new AbsenExport($data['month'], $data['year']),
                            "DataAbsen_{$data['month']}_{$data['year']}.xlsx"
                        );
                    }),

                Action::make('exportSemua')
                    ->label('Export Semua Data')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Export Semua Data')
                    ->modalSubheading('Data bisa sangat besar. Yakin mau export semua?')
                    ->modalButton('Ya, Export Semua')
                    ->action(function () {
                        return Excel::download(new AbsenExport(), 'absen_semua.xlsx');
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
            'index' => Pages\ListAbsens::route('/'),
            'create' => Pages\CreateAbsen::route('/create'),
            'edit' => Pages\EditAbsen::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_absen');
    }

}