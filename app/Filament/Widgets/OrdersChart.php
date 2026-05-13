<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Order Bulanan';

    protected int|string|array $columnSpan = 1;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Order::query()
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $labels = [];
        $values = [];

        foreach (range(1, 12) as $m) {
            $monthStr = str_pad((string) $m, 2, '0', STR_PAD_LEFT);
            $labels[] = \Carbon\Carbon::create()->month($m)->format('M');
            $values[] = $data->get($monthStr, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
