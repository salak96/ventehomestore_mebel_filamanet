<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Helpers\CartManagement;
use Livewire\Attributes\Title;

#[Title('Checkout - AndroidStore')]
class CheckoutPage extends Component
{
    public $first_name, $last_name, $phone, $payment_method;
    public $cart_items = [];
    public $grand_total = 0;

    protected $rules = [
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'nullable|string|max:255',
        'phone'          => 'required|string|max:20',
        'payment_method' => 'required|in:qris,stripe',
    ];

    protected $messages = [
        'first_name.required' => 'Nama depan wajib diisi.',
        'phone.required'      => 'Nomor telepon wajib diisi.',
        'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        'payment_method.in'   => 'Pilih metode pembayaran yang valid.',
    ];

    public function mount()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        if (count($this->cart_items) == 0) {
            return redirect('/products');
        }
    }

    public function render()
    {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        return view('livewire.checkout-page', [
            'cart_items'   => $this->cart_items,
            'grand_total'  => $this->grand_total,
        ]);
    }

    public function save()
    {
        $this->validate();

        $order = Order::create([
            'user_id'        => auth()->id(),
            'payment_method' => $this->payment_method,
            'grand_total'    => $this->grand_total,
        ]);

        $order->address()->create([
            'first_name'     => $this->first_name,
            'last_name'      => $this->last_name,
            'phone'          => $this->phone,
        ]);

        foreach ($this->cart_items as $item) {
            $order->items()->create([
                'product_id'   => $item['product_id'],
                'name'         => $item['name'],
                'quantity'     => $item['quantity'],
                'unit_amount'  => $item['unit_amount'],
                'total_amount' => $item['total_amount'],
            ]);
        }

        CartManagement::clearCartItems(); // ✅ hapus keranjang
    }

    public function saveAndSendWhatsapp()
    {
        $this->validate();

        $order = Order::create([
            'user_id'        => auth()->id(),
            'grand_total'    => $this->grand_total,
            'payment_method' => $this->payment_method,
        ]);

        $order->address()->create([
            'first_name'     => $this->first_name,
            'last_name'      => $this->last_name,
            'phone'          => $this->phone,
        ]);

        foreach ($this->cart_items as $item) {
            $order->items()->create([
                'product_id'   => $item['product_id'],
                'name'         => $item['name'],
                'quantity'     => $item['quantity'],
                'unit_amount'  => $item['unit_amount'],
                'total_amount' => $item['total_amount'],
            ]);
        }

        // Buat pesan WA
        $pesan = "*Halo Admin, ada pesanan baru!*\n\n".
            "*Nama:* {$this->first_name} {$this->last_name}\n".
            "*No. HP:* {$this->phone}\n\n".
            "*Detail Pesanan:*\n";

        foreach ($this->cart_items as $item) {
            $pesan .= "• {$item['name']} (x{$item['quantity']}) : Rp ".number_format($item['total_amount'],0,',','.')."\n";
        }

        $pesan .=                   "\n*Total:* Rp ".number_format($this->grand_total,0,',','.').
                  "\n*Metode:* ".($this->payment_method === 'stripe' ? 'Transfer Bank' : 'QRIS');

        $waUrl = "https://wa.me/6285642268279?text=".rawurlencode($pesan);

        $this->dispatch('open-whatsapp', $waUrl);

        CartManagement::clearCartItems(); // ✅ hapus keranjang setelah pesan WA
    }
}
