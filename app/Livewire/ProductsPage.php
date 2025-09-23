<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Schema;
use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Products - Ventehomestore')]
class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;

    // === FILTER STATE ===
    #[Url] public $selected_categories = [];
    #[Url] public $selected_brands = [];
    #[Url] public $featured;
    #[Url] public $onSale;
    #[Url] public $price_range = 0;
    #[Url] public $sort = 'latest';

    // NEW: query string ?q=...
    #[Url(as: 'q')]
    public string $search = ''; // NEW

    // NEW: reset halaman saat filter/search berubah
    public function updated($name): void // NEW
    {
        if (in_array($name, [
            'search',
            'sort',
            'selected_categories',
            'selected_brands',
            'featured',
            'onSale',
            'price_range'
        ])) {
            $this->resetPage();
        }
    }

    // add product to cart method
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Produk berhasil ditambahkan ke keranjang!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);
        $brands = Brand::where('is_active', 1)->get(['id', 'name', 'slug']);
        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']);

        // NEW: filter pencarian (nama, slug, deskripsi, sku)
        if (filled($this->search)) { // NEW
            $term = trim($this->search);
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $term) . '%';
            $productQuery->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                    ->orWhere('slug', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhere('sku', 'like', $like); // opsional: hapus jika tidak punya kolom sku
            });
        }

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if (!empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }

        if (!empty($this->featured)) {
            $productQuery->where('is_featured', $this->featured);
        }

        if (!empty($this->onSale)) {
            $productQuery->where('on_sale', $this->onSale);
        }

        if ($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        if ($this->sort === 'latest') {
            $productQuery->latest();
        } elseif ($this->sort === 'price') {
            $productQuery->orderBy('price');
        }
        // filter pencarian (nama, slug, deskripsi, opsional sku)
        if (filled($this->search)) {
            $term = trim($this->search);
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $term) . '%';

            $productQuery->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                    ->orWhere('slug', 'like', $like)
                    ->orWhere('description', 'like', $like);

                // hanya tambahkan jika kolom sku memang ada
                if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'sku')) {
                    $q->orWhere('sku', 'like', $like);
                }
            });
        }


        return view('livewire.products-page', [
            'products'   => $productQuery->paginate(9),
            'brands'     => $brands,
            'categories' => $categories,
        ]);
    }
}
