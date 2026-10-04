<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role Super Admin jika belum ada
        $role = Role::firstOrCreate(['name' => 'super_admin']);

        // 2. Ambil semua permission
        $allPermissions = Permission::pluck('name')->toArray();

        // 3. Beri role semua permission
        $role->syncPermissions(Permission::all());

        // 4. Buat user superadmin jika belum ada
        $user = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('SuperAdmin'),
            ]
        );

        // 5. Assign role super_admin ke user
        $user->assignRole($role);
    }
}
