<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;

class DigitalAccountSeeder extends Seeder
{
    protected $products = [
        'CTPAKET',
        'AM PREM',
        'AMAZON',
        'APPMUS',
        'BSTATION',
        'CAM SCANNER',
        'CANVA',
        'CAPCUT',
        'CEK TURNITIN',
        'CHATGPT',
        'DAZZCAM',
        'DISNEY',
        'DRAKOR ID',
        'DRAKORID',
        'DRAMABOX',
        'DUOLINGO',
        'GEMINI',
        'GRAMMARLY',
        'GROK',
        'GTC',
        'HBO',
        'ILOVEPDF',
        'IQIYI',
        'LIGHTROOM',
        'LOKLOK',
        'MEITU',
        'MICROSOFT 365',
        'MS 365',
        'NETFLIX',
        'PAYMENT',
        'PERBEDAAN NETFLIX',
        'PERPLEXITY',
        'PHOTOROOM',
        'PICSART',
        'PROMO',
        'QUILLBOT',
        'REMINI',
        'SCRIBD',
        'SPOTIFY',
        'SUNTIK FACEBOOK',
        'SUNTIK SHOPEE',
        'SUNTIK THREADS',
        'SUNTIK TIKTOK',
        'SUNTIK YOUTUBE',
        'VIDIO',
        'VIU',
        'VN PRO',
        'VSCO',
        'WETV',
        'WPS',
        'YOUKU',
        'YOUTUBE',
        'ZOOM',
    ];

    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'akun-digital'],
            [
                'name' => 'Akun Digital',
                'image' => null,
                'is_active' => true,
            ]
        );

        $brand = Brand::firstOrCreate(
            ['slug' => 'akun-digital-brand'],
            [
                'name' => 'Akun Digital',
                'image' => null,
                'is_active' => true,
            ]
        );

        foreach ($this->products as $productName) {
            $slug = Str::slug($productName);
            
            Product::firstOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'name' => $productName,
                    'sku' => 'AD-' . Str::upper(Str::substr(md5($productName), 0, 6)),
                    'images' => ['products/default.png'],
                    'description' => "Akun premium **{$productName}** dengan garansi resmi. Nikmati semua fitur premium tanpa batas.\n\n- Akun Original\n- Full Premium Features\n- Support 24/7",
                    'price' => rand(10, 500) * 1000,
                    'compare_at_price' => null,
                    'stock' => rand(50, 200),
                    'is_active' => true,
                    'is_featured' => false,
                    'on_sale' => false,
                ]
            );
        }
    }
}