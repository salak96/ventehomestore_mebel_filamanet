<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id', 'slug');
        $brands     = Brand::pluck('id', 'slug');

        $samples = [
            // Firmware STB
            ['name' => 'Firmware ZTE B860H V2',           'category' => 'firmware-stb', 'brand' => 'zte',       'price' => 50000,  'featured' => true,  'onsale' => false],
            ['name' => 'Firmware Huawei HG680P',           'category' => 'firmware-stb', 'brand' => 'huawei',    'price' => 55000,  'featured' => true,  'onsale' => false],
            ['name' => 'Firmware Akari ATV 2024',          'category' => 'firmware-stb', 'brand' => 'akari',     'price' => 45000,  'featured' => false, 'onsale' => true],
            ['name' => 'Firmware Evercoss STB One',        'category' => 'firmware-stb', 'brand' => 'evercoss',  'price' => 40000,  'featured' => false, 'onsale' => false],
            ['name' => 'Firmware Nexmedia NXT-1000',       'category' => 'firmware-stb', 'brand' => 'nexmedia',  'price' => 60000,  'featured' => true,  'onsale' => false],
            ['name' => 'Firmware Matrix SAT 4K',           'category' => 'firmware-stb', 'brand' => 'matrix',    'price' => 55000,  'featured' => false, 'onsale' => true],
            ['name' => 'Firmware Bravissimo B1',           'category' => 'firmware-stb', 'brand' => 'bravissimo','price' => 35000,  'featured' => false, 'onsale' => false],
            ['name' => 'Firmware Advan STB X1',            'category' => 'firmware-stb', 'brand' => 'advan',     'price' => 45000,  'featured' => false, 'onsale' => false],
            // Custom ROM
            ['name' => 'Custom ROM PixelOS Xiaomi Redmi 9','category' => 'custom-rom',   'brand' => 'xiaomi',    'price' => 75000,  'featured' => true,  'onsale' => false],
            ['name' => 'Custom ROM LineageOS Realme 5',    'category' => 'custom-rom',   'brand' => 'realme',    'price' => 80000,  'featured' => true,  'onsale' => false],
            ['name' => 'Custom ROM EvolutionX Advan G5',   'category' => 'custom-rom',   'brand' => 'advan',     'price' => 65000,  'featured' => false, 'onsale' => true],
            ['name' => 'Custom ROM crDroid Xiaomi Note 8', 'category' => 'custom-rom',   'brand' => 'xiaomi',    'price' => 70000,  'featured' => false, 'onsale' => false],
            // Jasa Root
            ['name' => 'Jasa Root Semua Xiaomi',           'category' => 'jasa-root',    'brand' => 'xiaomi',    'price' => 50000,  'featured' => true,  'onsale' => false],
            ['name' => 'Jasa Root Realme & Oppo',          'category' => 'jasa-root',    'brand' => 'realme',    'price' => 60000,  'featured' => false, 'onsale' => false],
            ['name' => 'Jasa Root Samsung & Advan',        'category' => 'jasa-root',    'brand' => 'advan',     'price' => 55000,  'featured' => false, 'onsale' => true],
            ['name' => 'Jasa Root Huawei & ZTE',           'category' => 'jasa-root',    'brand' => 'huawei',    'price' => 70000,  'featured' => false, 'onsale' => false],
            // Akun Digital
            ['name' => 'Akun Netflix Premium 1 Bulan',     'category' => 'akun-digital', 'brand' => 'xiaomi',   'price' => 35000,  'featured' => true,  'onsale' => false],
            ['name' => 'Akun Spotify Premium 3 Bulan',     'category' => 'akun-digital', 'brand' => 'realme',   'price' => 45000,  'featured' => true,  'onsale' => false],
            ['name' => 'Akun Canva Pro 1 Bulan',           'category' => 'akun-digital', 'brand' => 'advan',    'price' => 25000,  'featured' => false, 'onsale' => true],
            ['name' => 'Akun Youtube Premium 1 Bulan',     'category' => 'akun-digital', 'brand' => 'xiaomi',   'price' => 30000,  'featured' => false, 'onsale' => false],
            ['name' => 'Akun Disney+ Hotstar 1 Bulan',     'category' => 'akun-digital', 'brand' => 'realme',   'price' => 20000,  'featured' => false, 'onsale' => false],
            // Template Kreatif
            ['name' => 'Template CapCut Aesthetic 50+',    'category' => 'template-kreatif','brand' => 'xiaomi','price' => 15000,  'featured' => true,  'onsale' => false],
            ['name' => 'Template Canva Presentation Pro',  'category' => 'template-kreatif','brand' => 'realme','price' => 20000,  'featured' => false, 'onsale' => true],
            ['name' => 'Template CapCut Viral 2024',       'category' => 'template-kreatif','brand' => 'advan', 'price' => 25000,  'featured' => false, 'onsale' => false],
            ['name' => 'Template Canva Social Media',      'category' => 'template-kreatif','brand' => 'xiaomi','price' => 18000,  'featured' => false, 'onsale' => false],
            // Tools & Utility
            ['name' => 'Toolkit Flashing USB STB',         'category' => 'tools-utility','brand' => 'zte',      'price' => 85000,  'featured' => true,  'onsale' => false],
            ['name' => 'Driver Pack All STB',              'category' => 'tools-utility','brand' => 'huawei',   'price' => 30000,  'featured' => false, 'onsale' => false],
            ['name' => 'USB Serial TTL Converter',         'category' => 'tools-utility','brand' => 'akari',    'price' => 45000,  'featured' => false, 'onsale' => true],
        ];

        foreach ($samples as $p) {
            $catId = $categories[$p['category']] ?? null;
            $brandId = $brands[$p['brand']] ?? null;
            if (!$catId || !$brandId) continue;

            Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id' => $catId,
                    'brand_id'    => $brandId,
                    'name'        => $p['name'],
                    'images'      => json_encode(['products/default.png']),
                    'description' => 'Produk ' . $p['name'] . ' dari AndroidStore. Kualitas terjamin, harga terjangkau.',
                    'price'       => $p['price'],
                    'is_active'   => true,
                    'is_featured' => $p['featured'],
                    'in_stock'    => true,
                    'on_sale'     => $p['onsale'],
                ]
            );
        }
    }
}
