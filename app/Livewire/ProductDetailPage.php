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

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // add product to cart method
    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity);

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
        return view('livewire.product-detail-page', [
            'products' => Product::where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
