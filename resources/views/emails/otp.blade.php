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
                            <h1 style="color:#ffffff;font-size:24px;margin:0;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <h2 style="color:#1f2937;font-size:20px;margin:0 0 16px 0;">Kode OTP Reset Password</h2>
                            <p style="color:#4b5563;font-size:15px;line-height:1.6;margin:0 0 24px 0;">
                                Anda telah meminta reset password. Gunakan kode OTP di bawah ini:
                            </p>
                            <div style="background-color:#f0fdfa;border:2px dashed #0d9488;border-radius:8px;padding:20px;text-align:center;margin:0 0 24px 0;">
                                <span style="font-size:32px;font-weight:bold;color:#0d9488;letter-spacing:8px;">{{ $otp }}</span>
                            </div>
                            <p style="color:#6b7280;font-size:13px;line-height:1.5;margin:0 0 8px 0;">
                                Kode ini berlaku selama <strong>5 menit</strong>. Jika Anda tidak meminta reset password, abaikan email ini.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f9fafb;padding:20px 40px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;">
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
