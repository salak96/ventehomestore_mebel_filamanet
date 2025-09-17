<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@ventehome.test'], // ganti sesuai keinginan
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'), // ganti password
                'email_verified_at' => now(),
                'is_admin' => true, // pastikan kolom ini ada
                'remember_token' => Str::random(10),
            ]
        );
    }
}
