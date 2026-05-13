<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            color: #0d9488;
            font-size: 28px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info {
            margin-bottom: 30px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            vertical-align: top;
            padding: 5px 0;
        }

        .info .label {
            font-weight: bold;
            width: 120px;
            color: #555;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.items th {
            background: #0d9488;
            color: #fff;
            padding: 10px 12px;
            text-align: left;
            font-size: 13px;
        }

        table.items td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }

        table.items tr:nth-child(even) td {
            background: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-left: auto;
            width: 300px;
        }

        .summary table {
            width: 100%;
        }

        .summary td {
            padding: 6px 0;
        }

        .summary .total {
            font-size: 18px;
            font-weight: bold;
            color: #0d9488;
            border-top: 2px solid #0d9488;
            padding-top: 8px;
        }

        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>AndroidStore</p>
    </div>

    <div class="info">
        <table>
            <tr><td class="label">Invoice No</td><td>: {{ $order->id }}</td></tr>
            <tr><td class="label">Tanggal</td><td>: {{ $order->created_at->format('d F Y') }}</td></tr>
            <tr><td class="label">Status</td><td>: {{ ucfirst($order->status) }}</td></tr>
            <tr><td class="label">Pembayaran</td><td>: {{ ucfirst($order->payment_status) }}</td></tr>
            <tr><td class="label">Pelanggan</td><td>: {{ $order->customer_name }}</td></tr>
            <tr><td class="label">Telepon</td><td>: {{ $order->customer_phone }}</td></tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">Rp {{ number_format($item->unit_amount, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="text-right">Rp
                    {{ number_format($order->grand_total - ($order->shipping_amount ?? 0), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Ongkos Kirim</td>
                <td class="text-right">Rp {{ number_format($order->shipping_amount ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>Total</td>
                <td class="text-right">Rp {{ number_format($order->grand_total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja di AndroidStore</p>
        <p>{{ $order->payment_method == 'cod' ? 'Pembayaran dilakukan saat barang diterima (COD)' : 'Pembayaran melalui transfer bank' }}
        </p>
    </div>
</body>

</html>
