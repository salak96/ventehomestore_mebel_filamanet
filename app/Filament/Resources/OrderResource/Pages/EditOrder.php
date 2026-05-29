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
        $data['grand_total'] = collect($data['items'] ?? [])->sum(function($item) {
            return OrderResource::parseRupiah($item['total_amount'] ?? 0);
        });

        return $data;
    }

    protected function afterSave(): void
    {
        $order = $this->record;
        
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
