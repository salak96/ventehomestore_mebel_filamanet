<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:'Helvetica Neue',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background-color:#0d9488;padding:32px 40px;text-align:center;">
                            <img src="{{ config('app.url') }}/storage/logo.png" alt="{{ config('app.name') }}" style="max-height:50px;width:auto;">
                            <h1 style="color:#ffffff;font-size:24px;margin:16px 0 0 0;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <h2 style="color:#1f2937;font-size:20px;margin:0 0 16px 0;">Reset Password</h2>
                            <p style="color:#4b5563;font-size:15px;line-height:1.6;margin:0 0 16px 0;">Halo!</p>
                            <p style="color:#4b5563;font-size:15px;line-height:1.6;margin:0 0 16px 0;">
                                Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.
                            </p>
                            <table cellpadding="0" cellspacing="0" style="margin:24px 0;">
                                <tr>
                                    <td style="background-color:#0d9488;border-radius:6px;padding:12px 24px;">
                                        <a href="{{ $url }}" style="color:#ffffff;font-size:16px;font-weight:600;text-decoration:none;display:inline-block;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="color:#6b7280;font-size:13px;line-height:1.5;margin:0 0 8px 0;">
                                Link reset password ini akan kedaluwarsa dalam {{ $expire }} menit.
                            </p>
                            <p style="color:#6b7280;font-size:13px;line-height:1.5;margin:0 0 8px 0;">
                                Jika Anda tidak meminta reset password, abaikan email ini.
                            </p>
                            <p style="color:#6b7280;font-size:13px;line-height:1.5;margin:0 0 8px 0;">
                                Salam,<br>{{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f9fafb;padding:20px 40px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;">
                                Jika Anda mengalami kesulitan mengklik tombol "Reset Password", salin dan tempel URL di bawah ini di browser Anda:
                            </p>
                            <p style="color:#0d9488;font-size:12px;margin:8px 0 0 0;word-break:break-all;">
                                {{ $url }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
