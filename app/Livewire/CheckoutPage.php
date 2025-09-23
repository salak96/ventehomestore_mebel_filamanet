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
    public $first_name, $last_name, $phone, $address, $city, $state, $zip_code, $payment_method;
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
    // ✅ Validasi input
    $this->validate([
        'first_name' => 'required|string',
        'last_name'  => 'required|string',
        'phone'      => 'required|string',
        'address'    => 'required|string',
        'city'       => 'required|string',
        'state'      => 'required|string',
        'zip_code'   => 'required|string',
        'payment_method' => 'required|string',
    ]);

    // ✅ Simpan ke database
    $order = \App\Models\Order::create([
        'user_id'       => auth()->id(),   // 
        'first_name' => $this->first_name,
        'last_name'  => $this->last_name,
        'phone'      => $this->phone,
        'address'    => $this->address,
        'city'       => $this->city,
        'state'      => $this->state,
        'zip_code'   => $this->zip_code,
        'payment_method' => $this->payment_method,
        'grand_total' => $this->grand_total,
    ]);

//     // ✅ Buat pesan WA
//     $message = "Halo, saya ingin pesan.\n\n"
//              . "Nama: {$this->first_name} {$this->last_name}\n"
//              . "No HP: {$this->phone}\n"
//              . "Alamat: {$this->address}, {$this->city}, {$this->state}, {$this->zip_code}\n"
//              . "Metode Pembayaran: {$this->payment_method}\n"
//              . "Total: Rp " . number_format($this->grand_total, 0, ',', '.');

//     $url = "https://wa.me/6285642268279?text=" . urlencode($message);

//     // ✅ Kirim event ke frontend agar buka tab baru WA
//    $this->dispatch('open-whatsapp', url: $url);

//     // ✅ Kirim email konfirmasi
//     Mail::to(auth()->user()->email)->send(new OrderPlaced($order));

//     // ✅ Hapus cookie cart
//     CartManagement::clearCartCookie();

//     // ✅ Redirect ke halaman terima kasih
//     return redirect('/thank-you');

    
}
    public function orderViaWhatsapp()
{
    $orderText = "Halo, saya ingin memesan.\n\n"
        ."Rincian Pesanan:\n";

    foreach ($this->cart_items as $item) {
        $orderText .= $item['name'].' x'.$item['quantity'].' - Rp'.number_format($item['total_amount'], 0, ',', '.')."\n";
    }

    $orderText .= "\nTotal: Rp".number_format($this->grand_total, 0, ',', '.');

    $orderText .= "\n\nAlamat Pengiriman:\n"
        .$this->first_name.' '.$this->last_name."\n"
        .$this->address."\n"
        .$this->city.', '.$this->state.' '.$this->zip_code
        ."\nNomor HP: ".$this->phone;

    $orderText .= "\n\nMetode Pembayaran: ".ucwords(str_replace('_', ' ', $this->payment_method));

    $url = "https://wa.me/6285642268279?text=".urlencode($orderText);

    $this->dispatch('open-whatsapp', url: $url);
}

}
