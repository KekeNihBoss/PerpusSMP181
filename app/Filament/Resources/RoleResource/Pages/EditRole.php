<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $permissions = $this->record->permissions->pluck('name')->toArray();
        $grouped = [];

        foreach ($permissions as $perm) {
            if (preg_match('/^(view_any_|view_|create_|update_|delete_any_|delete_)(.*)$/', $perm, $matches)) {
                $action = $matches[1];
                $resource = $matches[2];

                if (in_array($action, ['view_', 'view_any_'])) {
                    $grouped[$resource]['view'] = true;
                } elseif ($action === 'create_') {
                    $grouped[$resource]['create'] = true;
                } elseif ($action === 'update_') {
                    $grouped[$resource]['update'] = true;
                } elseif (in_array($action, ['delete_', 'delete_any_'])) {
                    $grouped[$resource]['delete'] = true;
                }
            }
        }

        $data['permissions'] = $grouped;

        return $data;
    }

    protected function afterSave(): void
    {
        $role = $this->record;
        $data = $this->form->getState();

        $permissions = RoleResource::buildPermissionNames($data['permissions'] ?? []);

        $role->syncPermissions($permissions);
    }
}
