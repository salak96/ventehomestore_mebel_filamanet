<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Sudah Dikirim - {{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background: #f0f2f5;">

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f0f2f5; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="max-width: 580px;">

                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #0D9488 0%, #14B8A6 100%); padding: 30px 32px; border-radius: 12px 12px 0 0; text-align: center;">
                            <div style="font-size: 32px; margin-bottom: 12px;">📦</div>
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: -0.2px;">
                                Akun Sudah Dikirim
                            </h1>
                            <p style="margin: 8px 0 0 0; color: #ccfbf1; font-size: 14px;">
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>

                    {{-- Main Content --}}
                    <tr>
                        <td style="background: #ffffff; padding: 32px; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb;">

                            {{-- Greeting --}}
                            <p style="margin: 0 0 8px 0; color: #6b7280; font-size: 14px;">Halo,</p>
                            <h2 style="margin: 0 0 16px 0; color: #111827; font-size: 20px; font-weight: 700;">
                                {{ $order->user->name ?? 'User' }} 👋
                            </h2>

                            <p style="margin: 0 0 24px 0; color: #4b5563; font-size: 15px; line-height: 1.6;">
                                Akun untuk pesananmu sudah siap! Berikut detail akses yang bisa langsung dipakai:
                            </p>

                            {{-- Order Info Card --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 13px; font-weight: 500; width: 90px;">📋 Order</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px; font-weight: 600;">#{{ $order->id }}</td>
                                            </tr>
                                            @foreach ($order->items as $item)
                                                @php $product = $item->product; @endphp
                                                <tr>
                                                    <td style="padding: 8px 0; color: #6b7280; font-size: 13px; font-weight: 500;">📦 Produk</td>
                                                    <td style="padding: 8px 0; color: #111827; font-size: 14px;">
                                                        <strong>{{ $item->name ?: $product->name }}</strong>
                                                        @if ($item->quantity > 1)
                                                            <span style="color: #6b7280;"> x{{ $item->quantity }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td style="padding: 8px 0; color: #6b7280; font-size: 13px; font-weight: 500;">📧 Email</td>
                                                <td style="padding: 8px 0; color: #111827; font-size: 14px;">{{ $order->user->email ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- Access Credentials per Product --}}
                            @foreach ($order->items as $item)
                                @php $product = $item->product; @endphp
                                @if ($product && $product->access_link)
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 100%); border: 1px solid #99f6e4; border-radius: 10px; margin-bottom: 12px;">
                                        <tr>
                                            <td style="padding: 20px;">
                                                <div style="font-size: 13px; color: #0f766e; font-weight: 600; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                                                    🔑 Akses: {{ $item->name ?: $product->name }}
                                                </div>
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    @if ($product->access_link)
                                                        <tr>
                                                            <td style="padding: 4px 0; color: #4b5563; font-size: 13px; width: 90px;">Link</td>
                                                            <td style="padding: 4px 0;">
                                                                <a href="{{ $product->access_link }}" style="color: #0d9488; font-size: 13px; text-decoration: none; word-break: break-all;">{{ $product->access_link }}</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @if ($product->access_username)
                                                        <tr>
                                                            <td style="padding: 4px 0; color: #4b5563; font-size: 13px;">Username</td>
                                                            <td style="padding: 4px 0; color: #111827; font-size: 13px; font-family: 'Courier New', monospace; background: #f3f4f6; display: inline-block; padding: 4px 8px; border-radius: 4px;">{{ $product->access_username }}</td>
                                                        </tr>
                                                    @endif
                                                    @if ($product->access_password)
                                                        <tr>
                                                            <td style="padding: 4px 0; color: #4b5563; font-size: 13px;">Password</td>
                                                            <td style="padding: 4px 0; color: #111827; font-size: 13px; font-family: 'Courier New', monospace; background: #f3f4f6; display: inline-block; padding: 4px 8px; border-radius: 4px;">{{ $product->access_password }}</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                @endif
                            @endforeach

                            {{-- Note Card --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #fef3c7; border: 1px solid #fde68a; border-radius: 10px; margin: 24px 0;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <div style="color: #92400e; font-size: 13px; line-height: 1.6;">
                                            <strong>📝 Catatan:</strong> Maksimal login 2 device. Tidak lebih.
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- Warning Section --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <div style="color: #991b1b; font-size: 13px; font-weight: 600; margin-bottom: 8px;">
                                            ⚠️ Penting:
                                        </div>
                                        <ul style="margin: 0; padding-left: 18px; color: #7f1d1d; font-size: 13px; line-height: 1.8;">
                                            <li>Simpan pesan ini sebagai backup, jangan dihapus.</li>
                                            <li>Jangan bagikan akun ini ke pihak lain.</li>
                                            <li>Kalau ada kendala, klaim garansi via halaman pesanan.</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 12px 0; color: #6b7280; font-size: 13px; line-height: 1.6;">
                                Detail yang sama juga sudah dikirim ke email <strong>{{ $order->user->email ?? '-' }}</strong><br>
                                <span style="color: #9ca3af;">(cek folder Spam/Promotions kalau belum masuk)</span>
                            </p>

                            {{-- CTA Button --}}
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 24px 0 0 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('my-orders.index') }}" style="display: inline-block; background: linear-gradient(135deg, #0D9488 0%, #14B8A6 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-size: 15px; font-weight: 600; letter-spacing: 0.3px;">
                                            Lihat Detail Pesanan
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background: #1f2937; padding: 24px 32px; border-radius: 0 0 12px 12px; text-align: center;">
                            <p style="margin: 0 0 8px 0; color: #9ca3af; font-size: 13px;">
                                Terima kasih sudah belanja di
                            </p>
                            <p style="margin: 0 0 16px 0; color: #ffffff; font-size: 16px; font-weight: 700;">
                                {{ config('app.name') }}
                            </p>
                            <div style="height: 1px; background: #374151; margin: 16px 0;"></div>
                            <p style="margin: 0; color: #6b7280; font-size: 11px;">
                                Butuh bantuan? Balas email ini atau hubungi tim support kami.<br>
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
