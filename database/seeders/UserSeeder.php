<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Budi Santoso',     'email' => 'budi@gmail.com'],
            ['name' => 'Siti Rahmawati',   'email' => 'siti@gmail.com'],
            ['name' => 'Ahmad Fauzi',      'email' => 'ahmad@gmail.com'],
            ['name' => 'Dewi Lestari',     'email' => 'dewi@gmail.com'],
            ['name' => 'Rudi Hermawan',    'email' => 'rudi@gmail.com'],
            ['name' => 'Rina Fitriani',    'email' => 'rina@gmail.com'],
            ['name' => 'Agus Wijaya',      'email' => 'agus@gmail.com'],
            ['name' => 'Mega Putri',       'email' => 'mega@gmail.com'],
            ['name' => 'Doni Prasetyo',    'email' => 'doni@gmail.com'],
            ['name' => 'Indah Permata',    'email' => 'indah@gmail.com'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'     => $u['name'],
                    'password' => Hash::make('password'),
                    'is_admin' => false,
                ]
            );
        }
    }
}
