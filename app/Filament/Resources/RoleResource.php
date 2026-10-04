<?php

namespace App\Filament\Resources;

use Spatie\Permission\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\RoleResource\Pages\ManageRoles;
use App\Filament\Resources\RoleResource\Pages\EditRole;
use App\Filament\Resources\RoleResource\Pages\CreateRole;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Manajemen Admin';
    protected static ?string $navigationLabel = 'Roles';
    protected static ?string $slug = 'roles';
    protected static ?int $navigationSort = 51;

    /**
     * Daftar resource yang dikelola permission-nya, dikelompokkan berdasarkan section.
     */
    public static function getResourceGroups(): array
    {
        return [
            'Pengunjung' => [
                'description' => 'Kelola absensi siswa yang berkunjung ke perpustakaan.',
                'resources' => [
                    'absen' => 'Absen Pengunjung',
                ],
            ],
            'Master Data' => [
                'description' => 'Kelola data buku dan data siswa perpustakaan.',
                'resources' => [
                    'data::buku' => 'Data Buku',
                    'data::siswa' => 'Data Siswa',
                ],
            ],
            'Sirkulasi Buku' => [
                'description' => 'Kelola peminjaman dan pengembalian buku.',
                'resources' => [
                    'peminjaman' => 'Peminjaman',
                    'pengembalian' => 'Pengembalian',
                ],
            ],
            'Konten Website' => [
                'description' => 'Kelola konten yang ditampilkan di website perpustakaan.',
                'resources' => [
                    'book::recommendation' => 'Rekomendasi Bacaan',
                    'event' => 'Event',
                    'principal' => 'Kepala Sekolah',
                    'visi::misi' => 'Visi Misi',
                    'struktur::pengelola' => 'Struktur Pengelola',
                    'tata::tertib' => 'Tata Tertib',
                ],
            ],
            'Pengaturan Admin' => [
                'description' => 'Kelola user dan role akses admin panel.',
                'resources' => [
                    'user' => 'User',
                    'role' => 'Role',
                ],
            ],
        ];
    }

    public static function form(Form $form): Form
    {
        $groups = static::getResourceGroups();

        $permissionSections = [];

        foreach ($groups as $groupName => $group) {
            $resourceFields = [];

            foreach ($group['resources'] as $key => $label) {
                $resourceFields[] = Forms\Components\Fieldset::make($label)
                    ->schema([
                        Forms\Components\Checkbox::make("permissions.{$key}.select_all")
                            ->label('Pilih Semua')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) use ($key) {
                                $set("permissions.{$key}.view", $state);
                                $set("permissions.{$key}.create", $state);
                                $set("permissions.{$key}.update", $state);
                                $set("permissions.{$key}.delete", $state);
                            }),
                        Forms\Components\Checkbox::make("permissions.{$key}.view")
                            ->label('Lihat')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) use ($key) {
                                $set("permissions.{$key}.select_all", $state && $get("permissions.{$key}.create") && $get("permissions.{$key}.update") && $get("permissions.{$key}.delete"));
                            }),
                        Forms\Components\Checkbox::make("permissions.{$key}.create")
                            ->label('Tambah')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) use ($key) {
                                $set("permissions.{$key}.select_all", $state && $get("permissions.{$key}.view") && $get("permissions.{$key}.update") && $get("permissions.{$key}.delete"));
                            }),
                        Forms\Components\Checkbox::make("permissions.{$key}.update")
                            ->label('Edit')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) use ($key) {
                                $set("permissions.{$key}.select_all", $state && $get("permissions.{$key}.view") && $get("permissions.{$key}.create") && $get("permissions.{$key}.delete"));
                            }),
                        Forms\Components\Checkbox::make("permissions.{$key}.delete")
                            ->label('Hapus')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) use ($key) {
                                $set("permissions.{$key}.select_all", $state && $get("permissions.{$key}.view") && $get("permissions.{$key}.create") && $get("permissions.{$key}.update"));
                            }),
                    ])
                    ->columns(5);
            }

            $permissionSections[] = Forms\Components\Section::make($groupName)
                ->description($group['description'])
                ->icon(static::getGroupIcon($groupName))
                ->schema($resourceFields)
                ->collapsible()
                ->persistCollapsed()
                ->columns(1);
        }

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Role')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('Contoh: Petugas Absen'),

                Forms\Components\Section::make('Hak Akses')
                    ->description('Pilih fitur apa saja yang boleh diakses oleh role ini.')
                    ->icon('heroicon-o-key')
                    ->schema($permissionSections)
                    ->collapsible(),
            ]);
    }

    protected static function getGroupIcon(string $group): string
    {
        return match ($group) {
            'Pengunjung' => 'heroicon-o-users',
            'Master Data' => 'heroicon-o-circle-stack',
            'Sirkulasi Buku' => 'heroicon-o-arrow-path',
            'Konten Website' => 'heroicon-o-globe-alt',
            'Pengaturan Admin' => 'heroicon-o-cog-6-tooth',
            default => 'heroicon-o-squares-2x2',
        };
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Role')
                    ->sortable()
                    ->searchable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Jumlah Hak Akses'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y - H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    /**
     * Ubah struktur permission dari form menjadi nama permission Spatie.
     */
    public static function buildPermissionNames(array $permissionsData): array
    {
        $permissions = [];

        foreach ($permissionsData as $resource => $actions) {
            foreach ($actions as $action => $checked) {
                if ($action === 'select_all' || ! $checked) {
                    continue;
                }

                switch ($action) {
                    case 'view':
                        $permissions[] = "view_{$resource}";
                        $permissions[] = "view_any_{$resource}";
                        break;
                    case 'create':
                        $permissions[] = "create_{$resource}";
                        break;
                    case 'update':
                        $permissions[] = "update_{$resource}";
                        break;
                    case 'delete':
                        $permissions[] = "delete_{$resource}";
                        $permissions[] = "delete_any_{$resource}";
                        break;
                }
            }
        }

        return array_unique($permissions);
    }
}
