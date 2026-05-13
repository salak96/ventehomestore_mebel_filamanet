<?php

namespace App\Filament\Widgets;

use App\Models\VisitorTracking;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class VisitorStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kunjungan', VisitorTracking::where('action', 'view')->count()),
            Stat::make('Total Klik Keranjang', VisitorTracking::where('action', 'add_to_cart')->count()),
            Stat::make('Pengunjung Unik', VisitorTracking::where('action', 'view')->distinct('ip_address')->count('ip_address')),
            Stat::make('Kunjungan Hari Ini', VisitorTracking::where('action', 'view')->whereDate('created_at', today())->count()),
        ];
    }
}
