<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori & brand sudah ada
        $categories = Category::pluck('id', 'slug'); // slug => id
        $brands     = Brand::pluck('id', 'slug');    // slug => id

        // --- Contoh beberapa produk kurasi manual ---
        $samples = [
            [
                'name'        => 'Sofa L Minimalis Abu',
                'category'    => 'sofa',
                'brand'       => 'informa',
                'price'       => 4500000.00,
                'images'      => ['products/sofa-l-abu-1.jpg', 'products/sofa-l-abu-2.jpg'],
                'description' => 'Sofa bentuk L, rangka kayu solid, kain woven, cocok untuk ruang keluarga.',
                'is_featured' => true,
                'on_sale'     => false,
            ],
            [
                'name'        => 'Meja Makan Kayu Jati 6 Kursi',
                'category'    => 'meja',
                'brand'       => 'vivere',
                'price'       => 6800000.00,
                'images'      => ['products/meja-makan-jati-1.jpg'],
                'description' => 'Set meja makan kayu jati finishing natural, termasuk 6 kursi.',
                'is_featured' => false,
                'on_sale'     => true,
            ],
            [
                'name'        => 'Lemari Pakaian 3 Pintu Cermin',
                'category'    => 'lemari',
                'brand'       => 'olympic',
                'price'       => 3750000.00,
                'images'      => ['products/lemari-3-pintu-1.jpg'],
                'description' => 'Lemari pakaian 3 pintu dengan cermin dan ruang penyimpanan luas.',
                'is_featured' => false,
                'on_sale'     => false,
            ],
            [
                'name'        => 'Tempat Tidur Queen Storage',
                'category'    => 'tempat-tidur',
                'brand'       => 'ikea',
                'price'       => 5200000.00,
                'images'      => ['products/bed-queen-storage-1.jpg'],
                'description' => 'Rangka tempat tidur queen dengan laci penyimpanan di bawah.',
                'is_featured' => true,
                'on_sale'     => false,
            ],
        ];

        foreach ($samples as $p) {
            $categoryId = $categories[$p['category']] ?? null;
            $brandId    = $brands[$p['brand']] ?? null;
            if (!$categoryId || !$brandId) {
                continue;
            }

            Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id' => $categoryId,
                    'brand_id'    => $brandId,
                    'name'        => $p['name'],
                    'images'      => json_encode($p['images']),
                    'description' => $p['description'],
                    'price'       => $p['price'],
                    'is_active'   => true,
                    'is_featured' => (bool) ($p['is_featured'] ?? false),
                    'in_stock'    => true,
                    'on_sale'     => (bool) ($p['on_sale'] ?? false),
                ]
            );
        }

        // --- Tambahan: generate produk acak agar list ramai ---
        $faker       = \Faker\Factory::create('id_ID');
        $catSlugs    = $categories->keys()->values()->all();
        $brandSlugs  = $brands->keys()->values()->all();

        for ($i = 0; $i < 24; $i++) {
            $catSlug   = Arr::random($catSlugs);
            $brandSlug = Arr::random($brandSlugs);

            $name = ucfirst($faker->unique()->words(3, true)) . ' ' . strtoupper($faker->randomLetter);

            Product::updateOrCreate(
                ['slug' => Str::slug($name . '-' . $i)],
                [
                    'category_id' => $categories[$catSlug],
                    'brand_id'    => $brands[$brandSlug],
                    'name'        => $name,
                    'images'      => json_encode([
                        'products/dummy-' . $faker->numberBetween(1, 6) . '.jpg'
                    ]),
                    'description' => $faker->sentence(18),
                    'price'       => $faker->numberBetween(250000, 8000000),
                    'is_active'   => true,
                    'is_featured' => $faker->boolean(15),
                    'in_stock'    => $faker->boolean(90),
                    'on_sale'     => $faker->boolean(20),
                ]
            );
        }
    }
}
