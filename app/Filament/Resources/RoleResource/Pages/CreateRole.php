<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected ?array $permissionsData = [];

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->permissionsData = $data['permissions'] ?? [];
        unset($data['permissions']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $role = $this->record;
        $permissions = RoleResource::buildPermissionNames($this->permissionsData);

        $role->syncPermissions($permissions);
    }
}
