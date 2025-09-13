<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        AdminUser::create([
            'name' => 'Super Admin',
            'email' => 'admin@globalgpt.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        AdminUser::create([
            'name' => 'Admin User',
            'email' => 'user@globalgpt.com',
            'password' => Hash::make('user123'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
