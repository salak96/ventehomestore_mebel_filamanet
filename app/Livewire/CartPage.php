<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;

#[Title('Keranjang - AndroidStore')]
class CartPage extends Component
{
    public $cart_items = [];
    public $grand_total;

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function removeItem($cart_key)
    {
        $this->cart_items = CartManagement::removeCartItem($cart_key);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
    }

    public function increaseItem($cart_key)
    {
        $this->cart_items = CartManagement::incrementQuantityToCartItem($cart_key);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function decreaseItem($cart_key)
    {
        $this->cart_items = CartManagement::decrementQuantityToCartItem($cart_key);
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
