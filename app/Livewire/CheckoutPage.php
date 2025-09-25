<?php

namespace App\Livewire;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Mail\OrderPlaced;
use Stripe\Checkout\Session;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Mail;

#[Title('Checkout - DcodeMania')]
class CheckoutPage extends Component

{
    public $first_name, $last_name, $phone, $street_address, $city, $state, $zip_code, $payment_method;
    public $cart_items = [];
    public $grand_total = 0; // ✅ property untuk blade

    protected $rules = [
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'phone'          => 'required|numeric|digits_between:10,15',
        'address'        => 'required|string|max:500',
        'city'           => 'required|string|max:255',
        'state'          => 'required|string|max:255',
        'zip_code'       => 'required|numeric',
        'payment_method' => 'required|in:cod,stripe',
    ];

    protected $messages = [
        'first_name.required' => 'First name wajib diisi.',
        'last_name.required'  => 'Last name wajib diisi.',
        'phone.required'      => 'Nomor telepon wajib diisi.',
        'phone.numeric'       => 'Nomor telepon harus berupa angka.',
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
        // ✅ gunakan property, bukan variabel lokal
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        return view('livewire.checkout-page', [
            'cart_items' => $this->cart_items,
            'grand_total' => $this->grand_total,
        ]);
    }

 public function save()
{
    $this->validate();

    // 1. Simpan Order dulu
    $order = Order::create([
        'user_id'       => auth()->id(),
        'payment_method'=> $this->payment_method,
        'grand_total'   => $this->grand_total,
    ]);

    // 2. Simpan Address terkait Order
    $order->address()->create([
        'first_name'     => $this->first_name,
        'last_name'      => $this->last_name,
        'phone'          => $this->phone,
        'street_address' => $this->address,   // ✅ mapping dari input form
        'city'           => $this->city,
        'state'          => $this->state,
        'zip_code'       => $this->zip_code,
    ]);

    // 3. Simpan Items
    foreach ($this->cart_items as $item) {
        $order->items()->create([
            'product_id'   => $item['product_id'],
            'name'         => $item['name'],
            'quantity'     => $item['quantity'],
            'unit_amount'  => $item['unit_amount'],
            'total_amount' => $item['total_amount'],
        ]);
    }
}

public function saveAndSendWhatsapp()
{
    $this->validate([
        'first_name'      => 'required|string|max:255',
        'last_name'       => 'nullable|string|max:255',
        'phone'           => 'required|string|max:20',
        'street_address'  => 'required|string|max:500',
        'city'            => 'required|string|max:255',
        'state'           => 'required|string|max:255',
        'zip_code'        => 'required|string|max:20',
        'payment_method'  => 'required|string',
    ]);

    // Simpan order
    $order = \App\Models\Order::create([
        'user_id' => auth()->id(), // ambil id user yang login
        'grand_total' => $this->grand_total,
        'payment_method' => $this->payment_method,
    ]);

    // Simpan address
    $order->address()->create([
        'first_name'     => $this->first_name,
        'last_name'      => $this->last_name,
        'phone'          => $this->phone,
        'street_address' => $this->street_address,
        'city'           => $this->city,
        'state'          => $this->state,
        'zip_code'       => $this->zip_code,
    ]);

    // Buat pesan WA
    $pesan = "Halo Admin, ada pesanan baru!\n\n".
         "👤 Nama: {$this->first_name} {$this->last_name}\n".
         "📞 Telp: {$this->phone}\n".
         "🏠 Alamat: {$this->street_address}, {$this->city}, {$this->state}, {$this->zip_code}\n\n";

// Tambah detail barang
$pesan .= "🛒 Detail Pesanan:\n";
foreach ($this->cart_items as $item) {
    $pesan .= "- {$item['name']} (x{$item['quantity']}) : Rp ".number_format($item['total_amount'],0,',','.')."\n";
}

$pesan .= "\n💰 Total: Rp ".number_format($this->grand_total,0,',','.')."\n".
          "💳 Metode: {$this->payment_method}";

$waUrl = "https://wa.me/6285642268279?text=".rawurlencode($pesan);


    $this->dispatch('open-whatsapp', $waUrl);

}

}
