<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Orders', Order::query()->where('status', 'new')->count()),
            Stat::make('Order Processing', Order::query()->where('status', 'processing')->count()),
            Stat::make('Order Shipped', Order::query()->where('status', 'shipped')->count()),
            Stat::make('Average price', Order::query()->avg('grand_total') ? 'Rp ' . Number::format(Order::query()->avg('grand_total'), precision: 0, locale: 'id') : 'Rp 0')
        ];
    }
}
