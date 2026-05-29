<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Mail\OrderAccessMail;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
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
            
            Action::make('sendEmail')
                ->label('📧 Kirim Email Manual')
                ->color('success')
                ->icon('heroicon-o-envelope')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Kirim Email')
                ->modalDescription('Kirim email akses produk ke customer sekarang?')
                ->action(function () {
                    $order = $this->record;
                    
                    if (!$order->user || !$order->user->email) {
                        Notification::make()
                            ->danger()
                            ->title('Gagal')
                            ->body('Order tidak memiliki user/email yang valid.')
                            ->send();
                        return;
                    }
                    
                    try {
                        Mail::to($order->user->email)->send(new OrderAccessMail($order));
                        
                        Notification::make()
                            ->success()
                            ->title('Email Terkirim!')
                            ->body("Email berhasil dikirim ke {$order->user->email}")
                            ->send();
                        
                        Log::info("Manual: Email order akses dikirim untuk order #{$order->id} ke {$order->user->email}");
                    } catch (\Exception $e) {
                        Log::error("Manual: Gagal kirim email order #{$order->id}: " . $e->getMessage() . " | SMTP Host: " . config('mail.mailers.smtp.host'));
                        
                        Notification::make()
                            ->danger()
                            ->title('Gagal Kirim Email')
                            ->body("Error: " . $e->getMessage())
                            ->send();
                    }
                }),
            
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

        Log::info("EditOrder #{$this->record->id} - Items: " . count($items) . ", Grand Total: {$sum}");

        return $data;
    }

    protected function afterSave(): void
    {
        $order = $this->record;

        // Fallback: kalau grand_total masih 0, hitung ulang dari database
        if ($order->grand_total == 0 && $order->items()->count() > 0) {
            $sum = $order->items()->sum('total_amount');
            $order->updateQuietly(['grand_total' => $sum]);
            Log::info("EditOrder #{$order->id} - Grand total recalculated from DB: {$sum}");
        }

        // Kirim email otomatis kalau payment_status = success
        Log::info("EditOrder #{$order->id} - Checking email send condition", [
            'payment_status' => $order->payment_status,
            'has_user' => $order->user ? 'yes' : 'no',
            'user_email' => $order->user->email ?? null,
            'smtp_host' => config('mail.mailers.smtp.host'),
            'smtp_from' => config('mail.from.address'),
        ]);

        if ($order->payment_status === 'success' && $order->user && $order->user->email) {
            try {
                Mail::to($order->user->email)->send(new OrderAccessMail($order));
                Log::info("Email order akses berhasil dikirim untuk order #{$order->id} ke {$order->user->email}");
                
                Notification::make()
                    ->success()
                    ->title('Email Terkirim')
                    ->body("Akses produk sudah dikirim ke {$order->user->email}")
                    ->send();
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email order #{$order->id}: " . $e->getMessage());
                
                Notification::make()
                    ->warning()
                    ->title('Order Tersimpan, Email Gagal')
                    ->body("Order sukses diupdate tapi email gagal dikirim. Error: " . $e->getMessage() . ". Klik tombol '📧 Kirim Email Manual' untuk coba lagi.")
                    ->duration(8000)
                    ->send();
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
