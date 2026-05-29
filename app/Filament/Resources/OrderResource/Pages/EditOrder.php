<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Mail\OrderAccessMail;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Hitung grand_total dari items (prioritaskan data dari form)
        $items = $data['items'] ?? [];
        $sum = 0;
        foreach ($items as $item) {
            $totalAmount = $item['total_amount'] ?? 0;
            $sum += OrderResource::parseRupiah($totalAmount);
        }
        $data['grand_total'] = $sum;

        \Log::info("EditOrder #{$this->record->id} - Items: " . count($items) . ", Grand Total: {$sum}");

        return $data;
    }

    protected function afterSave(): void
    {
        $order = $this->record;

        // Fallback: kalau grand_total masih 0, hitung ulang dari database
        if ($order->grand_total == 0 && $order->items()->count() > 0) {
            $sum = $order->items()->sum('total_amount');
            $order->update(['grand_total' => $sum]);
            \Log::info("EditOrder #{$order->id} - Grand total recalculated from DB: {$sum}");
        }

        if ($order->payment_status === 'success' && $order->user && $order->user->email) {
            try {
                Mail::to($order->user->email)->send(new OrderAccessMail($order));
                Log::info("Email order akses berhasil dikirim untuk order #{$order->id} ke {$order->user->email}");
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email order #{$order->id}: " . $e->getMessage());
                session()->flash('warning', 'Order berhasil diupdate, tetapi email gagal dikirim: ' . $e->getMessage());
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
