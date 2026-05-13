<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Firmware STB',       'image' => 'categories/default.png'],
            ['name' => 'Custom ROM',         'image' => 'categories/default.png'],
            ['name' => 'Jasa Root',          'image' => 'categories/default.png'],
            ['name' => 'Akun Digital',       'image' => 'categories/default.png'],
            ['name' => 'Template Kreatif',   'image' => 'categories/default.png'],
            ['name' => 'Tools & Utility',    'image' => 'categories/default.png'],
        ];

        foreach ($items as $it) {
            Category::updateOrCreate(
                ['slug' => Str::slug($it['name'])],
                [
                    'name'      => $it['name'],
                    'image'     => $it['image'] ?? null,
                    'is_active' => true,
                ]
            );
        }
    }
}
