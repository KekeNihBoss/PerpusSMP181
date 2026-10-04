<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User test dihapus demi keamanan (password default bisa dieksploitasi).
        // Buat admin baru via SuperAdminSeeder saja.

        $this->call([
            RoleSeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}
