<?php

namespace App\Filament\Resources;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages;
use App\Filament\Resources\RoleResource\Pages\ManageRoles;
use App\Filament\Resources\RoleResource\Pages\EditRole;
use App\Filament\Resources\RoleResource\Pages\CreateRole;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = '! Roles & Users';
    protected static ?string $navigationLabel = 'Roles';
    protected static ?string $slug = 'roles';
    protected static ?int $navigationSort = 5; 

    public static function form(Form $form): Form
    {
        // Ambil semua resource dari nama permission
        $resources = [
            'absen' => 'Absen',
            'data::buku' => 'Data Buku',
            'data::siswa' => 'Data Siswa',
            'peminjaman' => 'Peminjaman',
            'pengembalian' => 'Pengembalian',
            'user' => 'User',
            'role' => 'Role',
        ];

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Role')
                    ->required()
                    ->unique(ignoreRecord: true),

Forms\Components\Fieldset::make('Hak Akses')
    ->schema(function () use ($resources) {
        $fields = [];

        foreach ($resources as $key => $label) {
            $fields[] = Forms\Components\Fieldset::make($label)
                ->schema([
                    // Checkbox Select All untuk section ini
                    Forms\Components\Checkbox::make("permissions.{$key}.select_all")
                        ->label('Pilih Semua')
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) use ($key) {
                            $set("permissions.{$key}.view", $state);
                            $set("permissions.{$key}.create", $state);
                            $set("permissions.{$key}.update", $state);
                            $set("permissions.{$key}.delete", $state);
                        }),
                    Forms\Components\Checkbox::make("permissions.{$key}.view")->label('Lihat')->reactive(),
                    Forms\Components\Checkbox::make("permissions.{$key}.create")->label('Tambah')->reactive(),
                    Forms\Components\Checkbox::make("permissions.{$key}.update")->label('Edit')->reactive(),
                    Forms\Components\Checkbox::make("permissions.{$key}.delete")->label('Hapus')->reactive(),
                ])
                ->columns(5);
        }

        return $fields;
    }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Role')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Jumlah Hak Akses'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y - H:i'),
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


//     public static function canViewAny(): bool
// {
//     return auth()->user()->hasRole('super_admin');
// }

}
