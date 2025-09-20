<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // cari berdasarkan email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // jangan lupa hash password
                'is_admin' => true, // field tambahan di user
            ]
        );
    }
}
