<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function generate($order_id)
    {
        $order = Order::with(['items.product', 'address', 'user'])->findOrFail($order_id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('invoice.pdf', ['order' => $order]);

        return $pdf->download("invoice-{$order->id}.pdf");
    }
}
