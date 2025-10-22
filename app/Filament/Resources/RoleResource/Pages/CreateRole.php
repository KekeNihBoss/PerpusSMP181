<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Permission;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil state permissions
        $this->permissionsData = $data['permissions'] ?? [];
        unset($data['permissions']); // hapus agar role bisa tersimpan dulu
        return $data;
    }

    protected function afterCreate(): void
    {
        // Ambil role baru
        $role = $this->record;

        $permissions = [];
        foreach ($this->permissionsData as $resource => $perms) {
            foreach ($perms as $key => $checked) {
                if ($key !== 'select_all' && $checked) {
                    // Map ke nama permission sebenarnya
                    $permissions[] = "{$key}_{$resource}";
                }
            }
        }

        // Sync ke role
        $role->syncPermissions($permissions);
    }
    
}
