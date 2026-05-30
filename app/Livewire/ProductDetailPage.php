<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\VisitorTracking;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\LivewireAlert;

#[Title('Detail Produk - AndroidStore')]
class ProductDetailPage extends Component
{
    use LivewireAlert;

    public $slug;
    public $quantity = 1;
    public $selected_variant_id = null;

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function selectVariant($variant_id)
    {
        $this->selected_variant_id = $variant_id;
        $this->quantity = 1;
    }

    public function increaseQty()
    {
        $max = $this->getAvailableStock();
        if ($max === null || $this->quantity < $max) {
            $this->quantity++;
        }
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    protected function getAvailableStock()
    {
        $product = Product::where('slug', $this->slug)->first();
        if (!$product) return 0;

        if ($this->selected_variant_id) {
            $variant = $product->variants()
                ->where('id', $this->selected_variant_id)
                ->where('is_active', true)
                ->first();
            return $variant ? $variant->stock : 0;
        }

        return $product->stock;
    }

    public function addToCart($product_id)
    {
        $stock = $this->getAvailableStock();

        if ($stock !== null && $this->quantity > $stock) {
            $this->alert('error', 'Stok tidak mencukupi!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        if ($stock === 0) {
            $this->alert('error', 'Stok habis!', [
                'position' => 'bottom-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity, $this->selected_variant_id);

        VisitorTracking::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'page_url'   => request()->fullUrl(),
            'action'     => 'add_to_cart',
        ]);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->dispatch('cart-updated-global', total_count: $total_count);

        $this->alert('success', 'Produk berhasil ditambahkan ke keranjang!', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $product = Product::with(['variants' => function ($q) {
            $q->where('is_active', true);
        }])->where('slug', $this->slug)->firstOrFail();

        $currentStock = $this->selected_variant_id
            ? optional($product->variants->firstWhere('id', $this->selected_variant_id))->stock ?? 0
            : $product->stock;

        $currentPrice = $this->selected_variant_id
            ? optional($product->variants->firstWhere('id', $this->selected_variant_id))->price ?? $product->price
            : $product->price;

        return view('livewire.product-detail-page', [
            'products'     => $product,
            'currentStock' => $currentStock,
            'currentPrice' => $currentPrice,
        ]);
    }
}
