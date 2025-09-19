<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Helpers\CartManagement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Mail\OrderPlaced;

#[Title('Checkout - Ventehomestore')]
class CheckoutPage extends Component
{
    // Form fields
    public $first_name;
    public $last_name;
    public $phone;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method = 'cod'; // default

    public function mount()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        if (count($cart_items) === 0) {
            return redirect('/products');
        }
    }

    public function render()
    {
        $cart_items   = CartManagement::getCartItemsFromCookie();
        $grand_total  = CartManagement::calculateGrandTotal($cart_items);

        return view('livewire.checkout-page', [
            'cart_items'  => $cart_items,
            'grand_total' => $grand_total,
        ]);
    }

    /** Aturan validasi tunggal */
    protected function rules()
    {
        return [
            'first_name'     => 'required|string|min:2',
            'last_name'      => 'required|string|min:2',
            'phone'          => 'required|string|min:9',
            'address'        => 'required|string|min:5',
            'city'           => 'required|string',
            'state'          => 'required|string',
            'zip_code'       => 'required|string',
            'payment_method' => 'required|in:cod,transfer',
        ];
    }

    /**
     * Checkout “biasa” (tanpa WA): simpan order & redirect ke halaman sukses.
     * Pakai ini jika kamu tetap butuh alur non-WhatsApp.
     */
    public function save()
    {
        $this->validate();

        $cart_items  = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        if (empty($cart_items)) {
            $this->addError('general', 'Keranjang kosong.');
            return;
        }

        DB::beginTransaction();
        try {
            // 1) Simpan Order
            $order = Order::create([
                'user_id'        => Auth::id(),
                'grand_total'    => $grand_total,
                'payment_method' => $this->payment_method, // cod / transfer
                'payment_status' => 'pending',
                'status'         => 'new',
                'currency'       => 'idr',
                'shipping_amount' => 0,
                'shipping_method' => 'none',
                'notes'          => 'Order Placed By ' . (Auth::user()->name ?? 'Guest'),
            ]);

            // 2) Simpan Alamat
            Address::create([
                'order_id'       => $order->id,
                'first_name'     => $this->first_name,
                'last_name'      => $this->last_name,
                'phone'          => $this->phone,
                'street_address' => $this->address,
                'city'           => $this->city,
                'state'          => $this->state,
                'zip_code'       => $this->zip_code,
            ]);

            // 3) Simpan Items (mapping dari cart)
            $itemsToCreate = array_map(function ($i) {
                $qty   = max(1, (int) $i['quantity']);
                $price = (int) $i['total_amount'] / $qty; // asumsi total_amount = price * qty
                return [
                    'product_id' => $i['product_id'] ?? null,
                    'name'       => $i['name'],
                    'price'      => (int) $price,
                    'quantity'   => (int) $qty,
                    'total'      => (int) $i['total_amount'],
                ];
            }, $cart_items);
            $order->items()->createMany($itemsToCreate);

            // 4) Clear cart & kirim email
            CartManagement::clearCartItems();
            if (Auth::user()) {
                Mail::to(Auth::user())->send(new OrderPlaced($order));
            }

            DB::commit();

            return redirect()->route('success'); // alur sukses biasa
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            $this->addError('general', 'Terjadi kesalahan saat menyimpan pesanan.');
        }
    }

    /**
     * Checkout via WhatsApp:
     * - Validasi
     * - Simpan order + alamat + items
     * - Redirect ke WA dengan nota pesanan
     */
    public function orderViaWhatsApp()
    {
        $this->validate();

        $cart_items  = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        if (empty($cart_items)) {
            $this->addError('general', 'Keranjang kosong.');
            return;
        }

        DB::beginTransaction();
        try {
            // 1) Simpan Order
            $order = Order::create([
                'user_id'        => Auth::id(),
                'grand_total'    => $grand_total,
                'payment_method' => $this->payment_method, // cod / transfer
                'payment_status' => 'pending',
                'status'         => 'new',
                'currency'       => 'idr',
                'shipping_amount' => 0,
                'shipping_method' => 'none',
                'notes'          => 'Order Placed By ' . (Auth::user()->name ?? 'Guest'),
            ]);

            // 2) Simpan Alamat
            Address::create([
                'order_id'       => $order->id,
                'first_name'     => $this->first_name,
                'last_name'      => $this->last_name,
                'phone'          => $this->phone,
                'street_address' => $this->address,
                'city'           => $this->city,
                'state'          => $this->state,
                'zip_code'       => $this->zip_code,
            ]);

            // 3) Simpan Items
            $itemsToCreate = array_map(function ($i) {
                $qty   = max(1, (int) $i['quantity']);
                $price = (int) $i['total_amount'] / $qty;
                return [
                    'product_id' => $i['product_id'] ?? null,
                    'name'       => $i['name'],
                    'price'      => (int) $price,
                    'quantity'   => (int) $qty,
                    'total'      => (int) $i['total_amount'],
                ];
            }, $cart_items);
            $order->items()->createMany($itemsToCreate);

            // 4) Clear cart & email
            CartManagement::clearCartItems();
            if (Auth::user()) {
                Mail::to(Auth::user())->send(new OrderPlaced($order));
            }

            DB::commit();

            // 5) Buat nota & redirect ke WhatsApp
            $rp = fn($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
// ... DB::commit();

            $rp = fn ($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
            $nota  = "Halo, saya ingin memesan (Order #{$order->id}):\n\n";
            foreach ($order->items as $it) {
                $nota .= "- {$it->name} ({$it->quantity}x) = {$rp($it->total)}\n";
            }
            $nota .= "\nTotal: {$rp($order->grand_total)}";
            $nota .= "\n\nNama: {$this->first_name} {$this->last_name}";
            $nota .= "\nTelp: {$this->phone}";
            $nota .= "\nAlamat: {$this->address}, {$this->city}, {$this->state} {$this->zip_code}";
            $nota .= "\nMetode: " . strtoupper($this->payment_method);

            // nomor WA tujuan
$whatsAppNumber = '6285642268279';

// link API WhatsApp (pakai api.whatsapp.com)
$link = 'https://api.whatsapp.com/send/?phone=' . $whatsAppNumber
      . '&text=' . urlencode($nota);

// Livewire v3:
$this->dispatch('open-wa', url: $link);

// --- Jika project kamu Livewire v2, pakai baris ini sebagai gantinya: ---
// $this->dispatchBrowserEvent('open-wa', ['url' => $link]);

// (opsional) tampilkan flash message di halaman sekarang
session()->flash('success', 'Pesanan tersimpan. Membuka WhatsApp di tab baru...');

            // $this->dispatchBrowserEvent('open-wa', ['url' => $link]);

            // OPTIONAL: tampilkan notifikasi sukses di halaman saat ini
            session()->flash('success', 'Pesanan tersimpan. Membuka WhatsApp di tab baru...');
            // return redirect()->route('success'); // alur sukses biasa


            return redirect()->away($link);
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            $this->addError('general', 'Terjadi kesalahan saat menyimpan pesanan.');
        }
    }
}
