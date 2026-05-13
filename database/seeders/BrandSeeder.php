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
            ['name' => 'ZTE',         'image' => 'brands/zte.png'],
            ['name' => 'Huawei',      'image' => 'brands/huawei.png'],
            ['name' => 'Akari',       'image' => 'brands/akari.png'],
            ['name' => 'Evercoss',    'image' => 'brands/evercoss.png'],
            ['name' => 'Nexmedia',    'image' => 'brands/nexmedia.png'],
            ['name' => 'Matrix',      'image' => 'brands/matrix.png'],
            ['name' => 'Bravissimo',  'image' => 'brands/bravissimo.png'],
            ['name' => 'Advan',       'image' => 'brands/advan.png'],
            ['name' => 'Xiaomi',      'image' => 'brands/xiaomi.png'],
            ['name' => 'Realme',      'image' => 'brands/realme.png'],
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
