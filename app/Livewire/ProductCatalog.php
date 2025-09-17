<?php

namespace App\Livewire\Catalog;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    // Tailwind untuk pagination (opsional, Livewire v3 defaultnya Tailwind juga)
    protected string $paginationTheme = 'tailwind';

    // Simpan state di URL (opsional tapi enak buat share link)
    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $sort = 'latest';

    #[Url]
    public array $selected_categories = [];

    #[Url]
    public array $selected_brands = [];

    #[Url]
    public bool $featured = false;

    #[Url]
    public bool $onSale = false;

    #[Url]
    public int $price_range = 5000000;

    // Reset ke halaman 1 kalau filter berubah
    public function updated($name): void
    {
        if (in_array($name, [
            'search','sort','selected_categories','selected_brands','featured','onSale','price_range'
        ])) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->sort = 'latest';
        $this->selected_categories = [];
        $this->selected_brands = [];
        $this->featured = false;
        $this->onSale = false;
        $this->price_range = 5000000;
        $this->resetPage();
    }

    public function addToCart(int $productId): void
    {
        // Implementasi sesuai kebutuhanmu
        // contoh: Cart::add($productId);
        $this->dispatch('cart-added', id: $productId);
    }

    public function render()
    {
        $query = Product::query()
            ->with(['brand','categories'])
            ->when($this->search, function ($q) {
                $term = '%'.trim($this->search).'%';
                $q->where(function ($qq) use ($term) {
                    $qq->where('name', 'like', $term)
                       ->orWhere('slug', 'like', $term)
                       ->orWhere('description', 'like', $term);
                });
            })
            ->when(!empty($this->selected_categories), function ($q) {
                $q->whereHas('categories', function ($qq) {
                    $qq->whereIn('categories.id', $this->selected_categories);
                });
            })
            ->when(!empty($this->selected_brands), function ($q) {
                $q->whereIn('brand_id', $this->selected_brands);
            })
            ->when($this->featured, fn($q) => $q->where('featured', true))
            ->when($this->onSale, fn($q) => $q->where('on_sale', true))
            ->when($this->price_range > 0, fn($q) => $q->where('price', '<=', $this->price_range));

        // Sorting
        $query = match ($this->sort) {
            'price' => $query->orderBy('price')->orderByDesc('id'),
            default => $query->orderByDesc('created_at')->orderByDesc('id'),
        };

        $products   = $query->paginate(12);
        $categories = Category::query()->orderBy('name')->get();
        $brands     = Brand::query()->orderBy('name')->get();

        return view('livewire.catalog.product-catalog', compact('products','categories','brands'));
    }
}
