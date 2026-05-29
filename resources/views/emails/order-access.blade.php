<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; border-radius: 8px; padding: 30px;">
        <h2 style="color: #0D9488;">Terima Kasih, {{ $order->customer_name }}!</h2>
        <p>Pembayaran untuk pesanan <strong>#{{ $order->id }}</strong> telah dikonfirmasi.</p>
        <p>Berikut detail akses produk kamu:</p>

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr style="background: #f9f9f9;">
                <th style="text-align: left; padding: 10px; border-bottom: 1px solid #ddd;">Produk</th>
                <th style="text-align: left; padding: 10px; border-bottom: 1px solid #ddd;">Link</th>
                <th style="text-align: left; padding: 10px; border-bottom: 1px solid #ddd;">Username</th>
                <th style="text-align: left; padding: 10px; border-bottom: 1px solid #ddd;">Password</th>
            </tr>
            @foreach ($order->items as $item)
                @php $product = $item->product @endphp
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $item->name ?: $product->name }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                        @if ($product->access_link)
                            <a href="{{ $product->access_link }}" style="color: #0D9488;">Klik di sini</a>
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $product->access_username ?: '-' }}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $product->access_password ?: '-' }}</td>
                </tr>
            @endforeach
        </table>

        <p style="margin-top: 30px;">Jika ada pertanyaan, silakan hubungi kami.</p>
        <p style="color: #666;">Salam,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>