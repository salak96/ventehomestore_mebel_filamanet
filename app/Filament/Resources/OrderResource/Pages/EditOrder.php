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
            
            Action::make('sendWhatsapp')
                ->label('📱 Kirim via WhatsApp')
                ->color('success')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->action(function () {
                    $order = $this->record->load(['user', 'items.product']);
                    $this->sendWhatsappMessage($order);
                }),
            
            Action::make('sendEmail')
                ->label('📧 Kirim Email Manual')
                ->color('info')
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
                        Log::error("Manual: Gagal kirim email order #{$order->id}: " . $e->getMessage());
                        
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

    protected function sendWhatsappMessage($order): void
    {
        $phone = $order->customer_phone ?? $order->user->phone ?? null;
        
        if (empty($phone)) {
            Notification::make()
                ->danger()
                ->title('Nomor WA Tidak Ada')
                ->body('Order ini tidak memiliki nomor telepon customer.')
                ->send();
            return;
        }

        // Format nomor ke internasional: 08xx → 628xx
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        // Build pesan WA
        $appName = config('app.name');
        $message = "📦 *Akun Sudah Dikirim — {$appName}*\n\n";
        $message .= "Halo *{$order->user->name}*,\nAkun untuk pesananmu sudah siap! 👋\n\n";
        
        $message .= "📋 *Order:* #{$order->id}\n";
        
        foreach ($order->items as $item) {
            $product = $item->product;
            $qtyText = $item->quantity > 1 ? " x{$item->quantity}" : "";
            $message .= "📦 *Produk:* {$item->name}{$qtyText}\n";
            
            if ($product && $product->access_link) {
                $message .= "🔗 *Link:* {$product->access_link}\n";
            }
            if ($product && $product->access_username) {
                $message .= "👤 *Username:* `{$product->access_username}`\n";
            }
            if ($product && $product->access_password) {
                $message .= "🔑 *Password:* `{$product->access_password}`\n";
            }
            $message .= "\n";
        }
        
        $message .= "📧 *Email:* {$order->user->email}\n\n";
        
        $message .= "📝 *Catatan:*\n";
        $message .= "Maksimal login 2 device. Tidak lebih.\n\n";
        
        $message .= "⚠️ *Penting:*\n";
        $message .= "• Simpan pesan ini sebagai backup, jangan dihapus.\n";
        $message .= "• Jangan bagikan akun ini ke pihak lain.\n";
        $message .= "• Kalau ada kendala, klaim garansi via halaman pesanan.\n\n";
        
        $message .= "Detail lengkap juga sudah dikirim ke email *{$order->user->email}*\n";
        $message .= "_(cek folder Spam/Promotions kalau belum masuk)_\n\n";
        
        $message .= "🔗 *Cek detail pesanan:*\n" . route('my-orders.index') . "\n\n";
        
        $message .= "Terima kasih sudah belanja di *{$appName}*! 🙏";

        // Simpan pesan ke log (backup kalau user copy manual)
        Log::info("WhatsApp message for order #{$order->id}:", [
            'phone' => $phone,
            'message' => $message,
        ]);

        // Buka WhatsApp dengan pesan pre-filled
        $waUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
        
        Notification::make()
            ->success()
            ->title('WhatsApp Siap Dikirim')
            ->body("Nomor: +{$phone}. Klik tombol di bawah untuk buka WhatsApp.")
            ->actions([
                \Filament\Notifications\Actions\Action::make('open_wa')
                    ->label('📱 Buka WhatsApp')
                    ->url($waUrl, shouldOpenInNewTab: true)
                    ->color('success'),
            ])
            ->persistent()
            ->send();
        
        // Juga open di tab baru langsung
        $this->js("window.open('{$waUrl}', '_blank')");
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
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email order #{$order->id}: " . $e->getMessage());
                // Tidak tampilkan notifikasi lagi karena sudah ada tombol manual WA
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
