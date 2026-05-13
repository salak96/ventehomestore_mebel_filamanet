<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\OrderItem;

#[Title('Order Detail')]
class DetailOrderPage extends Component
{
    public $order_id;

    public function mount($order_id)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        $order_items = OrderItem::with('product')->where('order_id', $this->order_id)->get();
        $order = Order::where('id', $this->order_id)->first();

        return view('livewire.detail-order-page', [
            'order_items' => $order_items,
            'order' => $order
        ]);
    }
}
