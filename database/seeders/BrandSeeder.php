<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Informa',     'image' => 'brands/informa.png'],
            ['name' => 'IKEA',        'image' => 'brands/ikea.png'],
            ['name' => 'Olympic',     'image' => 'brands/olympic.png'],
            ['name' => 'Vivere',      'image' => 'brands/vivere.png'],
            ['name' => 'iFurnholic',  'image' => 'brands/ifurnholic.png'],
            ['name' => 'Ace',         'image' => 'brands/ace.png'],
            ['name' => 'Mabelio',     'image' => 'brands/mabelio.png'],
        ];

        foreach ($items as $it) {
            Brand::updateOrCreate(
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
