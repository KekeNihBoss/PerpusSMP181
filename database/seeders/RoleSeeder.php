<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Daftar role default beserta resource yang boleh diakses.
     * Setiap resource akan diberi permission Lihat, Tambah, Edit, dan Hapus.
     */
    protected array $roleDefinitions = [
        'super_admin' => [
            'description' => 'Akses penuh ke seluruh fitur admin panel.',
            'resources' => [], // kosong = semua permission
        ],
        'admin_perpustakaan' => [
            'description' => 'Mengelola data buku, data siswa, peminjaman, dan pengembalian.',
            'resources' => [
                'data::buku',
                'data::siswa',
                'peminjaman',
                'pengembalian',
            ],
        ],
        'admin_konten' => [
            'description' => 'Mengelola konten website perpustakaan.',
            'resources' => [
                'book::recommendation',
                'event',
                'principal',
                'visi::misi',
                'struktur::pengelola',
                'tata::tertib',
            ],
        ],
        'petugas_absen' => [
            'description' => 'Hanya mencatat absensi pengunjung perpustakaan.',
            'resources' => [
                'absen',
            ],
        ],
    ];

    /**
     * Permission untuk manajemen admin panel (user & role),
     * dipakai oleh form RoleResource dan policy.
     */
    protected array $adminPanelResources = ['user', 'role'];

    public function run(): void
    {
        // Pastikan permission user & role selalu tersedia
        foreach ($this->adminPanelResources as $resource) {
            foreach (['view', 'view_any', 'create', 'update', 'delete', 'delete_any'] as $action) {
                Permission::firstOrCreate(["name" => "{$action}_{$resource}", 'guard_name' => 'web']);
            }
        }

        foreach ($this->roleDefinitions as $roleName => $definition) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);

            if (empty($definition['resources'])) {
                // Super admin: beri semua permission yang tersedia
                $role->syncPermissions(Permission::all());
                continue;
            }

            $permissionNames = [];

            foreach ($definition['resources'] as $resource) {
                $permissionNames = array_merge($permissionNames, [
                    "view_{$resource}",
                    "view_any_{$resource}",
                    "create_{$resource}",
                    "update_{$resource}",
                    "delete_{$resource}",
                    "delete_any_{$resource}",
                ]);
            }

            // Pastikan permission sudah ada di database
            foreach ($permissionNames as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
            }

            $role->syncPermissions($permissionNames);
        }
    }
}
