<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Permission;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getRedirectUrl(): string{
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load permission yang sudah ada di DB
        $permissions = $this->record->permissions->pluck('name')->toArray();

        $grouped = [];

        foreach ($permissions as $perm) {
            if (preg_match('/^(view_any_|view_|create_|update_|delete_any_|delete_)(.*)$/', $perm, $matches)) {
                $action = $matches[1];
                $resource = $matches[2];

                // Normalisasi biar sesuai field
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
        $role->syncPermissions([]);

        foreach ($data['permissions'] ?? [] as $resource => $actions) {
            foreach ($actions as $action => $checked) {
                if (!$checked) continue;

                switch ($action) {
                    case 'view':
                        $role->givePermissionTo("view_{$resource}");
                        $role->givePermissionTo("view_any_{$resource}");
                        break;
                    case 'create':
                        $role->givePermissionTo("create_{$resource}");
                        break;
                    case 'update':
                        $role->givePermissionTo("update_{$resource}");
                        break;
                    case 'delete':
                        $role->givePermissionTo("delete_{$resource}");
                        $role->givePermissionTo("delete_any_{$resource}");
                        break;
                }
            }
        }
    }
}
