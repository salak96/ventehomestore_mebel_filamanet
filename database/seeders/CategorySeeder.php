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
            ['name' => 'Sofa',           'image' => 'categories/sofa.jpg'],
            ['name' => 'Kursi',          'image' => 'categories/kursi.jpg'],
            ['name' => 'Meja',           'image' => 'categories/meja.jpg'],
            ['name' => 'Lemari',         'image' => 'categories/lemari.jpg'],
            ['name' => 'Tempat Tidur',   'image' => 'categories/tempat-tidur.jpg'],
            ['name' => 'Rak',            'image' => 'categories/rak.jpg'],
            ['name' => 'Dekorasi',       'image' => 'categories/dekorasi.jpg'],
            ['name' => 'Outdoor',        'image' => 'categories/outdoor.jpg'],
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
