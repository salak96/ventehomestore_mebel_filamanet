<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $items = $data['items'] ?? [];
        $sum = 0;
        foreach ($items as $item) {
            $totalAmount = $item['total_amount'] ?? 0;
            $sum += OrderResource::parseRupiah($totalAmount);
        }
        $data['grand_total'] = $sum;

        Log::info("CreateOrder - Items: " . count($items) . ", Grand Total: {$sum}");

        return $data;
    }

    protected function afterCreate(): void
    {
        $order = $this->record;

        // Fallback: kalau grand_total masih 0, hitung ulang dari database
        if ($order->grand_total == 0 && $order->items()->count() > 0) {
            $sum = $order->items()->sum('total_amount');
            $order->update(['grand_total' => $sum]);
            Log::info("CreateOrder #{$order->id} - Grand total recalculated from DB: {$sum}");
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}