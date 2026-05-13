<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Bulanan';

    protected int|string|array $columnSpan = 'full';

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
        {
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            }
        }
        JS);
    }

    protected function getData(): array
    {
        $data = Order::query()
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%m') as month"),
                DB::raw('SUM(grand_total) as total')
            )
            ->whereNotNull('grand_total')
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
                    'label' => 'Pendapatan (Rp)',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
