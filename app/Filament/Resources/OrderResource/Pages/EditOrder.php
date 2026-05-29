<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Mail\OrderAccessMail;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

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
        $data['grand_total'] = collect($data['items'] ?? [])->sum(fn($item) => (int) ($item['total_amount'] ?? 0));

        return $data;
    }

    protected function afterSave(): void
    {
        $order = $this->record;
        if ($order->payment_status === 'success' && $order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderAccessMail($order));
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
