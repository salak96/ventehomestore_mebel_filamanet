<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Order';

    protected int|string|array $columnSpan = 1;

    protected static ?string $maxHeight = '300px';

    protected function getOptions(): array
    {
        return [
            'plotOptions' => [
                'pie' => [
                    'donut' => [
                        'size' => '70%',
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
                'style' => [
                    'fontSize' => '12px',
                ],
            ],
            'legend' => [
                'position' => 'bottom',
            ],
        ];
    }

    protected function getData(): array
    {
        $data = Order::query()
            ->select('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $colors = [
            'new' => '#3b82f6',
            'processing' => '#f59e0b',
            'shipped' => '#8b5cf6',
            'delivered' => '#22c55e',
            'cancelled' => '#ef4444',
        ];

        return [
            'datasets' => [
                [
                    'data' => $data->values(),
                    'backgroundColor' => $data->keys()->map(fn ($s) => $colors[$s] ?? '#6b7280'),
                ],
            ],
            'labels' => $data->keys()->map(fn ($s) => ucfirst($s)),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
