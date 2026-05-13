<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class TopProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Produk Terlaris';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = OrderItem::query()
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Terjual',
                    'data' => $data->pluck('total_qty'),
                ],
            ],
            'labels' => $data->pluck('name')->map(fn ($n) => \Illuminate\Support\Str::limit($n, 20)),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
