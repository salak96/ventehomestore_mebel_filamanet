<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->pluck('id');
        $products = Product::pluck('price', 'id');

        if ($users->isEmpty() || $products->isEmpty()) return;

        $statuses = ['new', 'processing', 'shipped', 'delivered', 'cancelled'];
        $payments = ['transfer_bank', 'cod', 'gopay', 'ovo', 'dana'];
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Semarang', 'Medan', 'Makassar', 'Palembang'];

        $orders = [];

        // Create 40 orders spread over the past 30 days
        $userIds = $users->toArray();
        for ($i = 0; $i < 40; $i++) {
            $userId = $userIds[array_rand($userIds)];
            $status = $statuses[array_rand($statuses)];
            $daysAgo = rand(0, 30);
            $hoursAgo = rand(0, 23);
            $date = now()->subDays($daysAgo)->subHours($hoursAgo);

            // Pick 1-3 random products for this order
            $itemCount = rand(1, 3);
            $keys = $products->keys();
            $picked = $keys->random(min($itemCount, $keys->count()));
            $itemProductIds = $picked instanceof \Illuminate\Support\Collection ? $picked->toArray() : [$picked];

            $total = 0;
            $items = [];
            foreach ($itemProductIds as $pid) {
                $qty = rand(1, 2);
                $unitPrice = $products[$pid];
                $items[] = [
                    'product_id'   => $pid,
                    'quantity'     => $qty,
                    'unit_amount'  => $unitPrice,
                    'total_amount' => $qty * $unitPrice,
                    'created_at'   => $date,
                    'updated_at'   => $date,
                ];
                $total += $qty * $unitPrice;
            }

            $firstName = ['Budi', 'Siti', 'Ahmad', 'Dewi', 'Rudi', 'Rina', 'Agus', 'Mega', 'Doni', 'Indah'][array_rand(['Budi', 'Siti', 'Ahmad', 'Dewi', 'Rudi', 'Rina', 'Agus', 'Mega', 'Doni', 'Indah'])];
            $lastName = ['Santoso', 'Rahmawati', 'Fauzi', 'Lestari', 'Hermawan', 'Fitriani', 'Wijaya', 'Putri', 'Prasetyo', 'Permata'][array_rand(['Santoso', 'Rahmawati', 'Fauzi', 'Lestari', 'Hermawan', 'Fitriani', 'Wijaya', 'Putri', 'Prasetyo', 'Permata'])];

            $orders[] = [
                'user_id'         => $userId,
                'customer_name'   => "$firstName $lastName",
                'customer_phone'  => '08' . rand(1000000000, 9999999999),
                'grand_total'     => $total,
                'payment_method'  => $payments[array_rand($payments)],
                'payment_status'  => $status === 'cancelled' ? 'failed' : 'paid',
                'status'          => $status,
                'currency'        => 'IDR',
                'shipping_amount' => 0,
                'shipping_method' => 'JNE',
                'notes'           => null,
                'created_at'      => $date,
                'updated_at'      => $date,
                'items'           => $items,
            ];
        }

        foreach ($orders as $o) {
            $order = Order::create([
                'user_id'         => $o['user_id'],
                'grand_total'     => $o['grand_total'],
                'payment_method'  => $o['payment_method'],
                'payment_status'  => $o['payment_status'],
                'status'          => $o['status'],
                'currency'        => $o['currency'],
                'shipping_amount' => $o['shipping_amount'],
                'shipping_method' => $o['shipping_method'],
                'notes'           => $o['notes'],
                'created_at'      => $o['created_at'],
                'updated_at'      => $o['updated_at'],
            ]);

            foreach ($o['items'] as $item) {
                $order->items()->create($item);
            }
        }
    }
}
