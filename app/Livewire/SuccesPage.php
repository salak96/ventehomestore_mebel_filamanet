<?php

namespace App\Livewire;

use Stripe\Stripe;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Url;
use Stripe\Checkout\Session;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderAccessMail;

#[Title('Success - AndroidStore')]
class SuccesPage extends Component
{
    #[Url]
    public $session_id;

    private function sendAccessEmail(Order $order): void
    {
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderAccessMail($order));
        }
    }

    public function render()
    {
        $latest_order = Order::where('user_id', auth()->user()->id)->latest()->first();

        if ($this->session_id) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session_info = Session::retrieve($this->session_id);

            if ($session_info->payment_status != 'paid') {
                $latest_order->payment_status = 'failed';
                $latest_order->save();
                return redirect->route('cancel');
            } else if ($session_info->payment_status == 'paid') {
                $latest_order->payment_status = 'success';
                $latest_order->save();
                $this->sendAccessEmail($latest_order);
            }
        }

        return view('livewire.succes-page', [
            'order' => $latest_order,
        ]);
    }
}
