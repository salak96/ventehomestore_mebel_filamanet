<x-mail::message>
# Pesanan Berhasil Dibuat 🎉

Terima kasih telah berbelanja di {{ config('app.name') }}.  
Nomor pesanan: **#{{ $order->code ?? $order->id }}**  
Tanggal: **{{ optional($order->created_at)->timezone(config('app.timezone', 'Asia/Jakarta'))->format('d M Y, H:i') }}**

<x-mail::panel>
Kami sedang menyiapkan pesanan Anda. Detail ringkasan ada di bawah ini.
</x-mail::panel>

{{-- Daftar Item --}}
<x-mail::table>
| Produk | Qty | Harga | Subtotal |
|:--|:--:|--:|--:|
@foreach($order->items ?? [] as $item)
| {{ $item->name ?? 'Produk' }} @if(!empty($item->variant)) <br><small>Varian: {{ $item->variant }}</small>@endif | {{ $item->quantity ?? 1 }} | {{ Number::currency($item->unit_price ?? 0, 'IDR') }} | {{ Number::currency(($item->total ?? ($item->unit_price ?? 0) * ($item->quantity ?? 1)), 'IDR') }} |
@endforeach
</x-mail::table>

{{-- Ringkasan Pembayaran --}}
**Ringkasan Pembayaran**

@php
  $subtotal   = $order->subtotal   ?? ($order->items?->sum(fn($i) => ($i->unit_price ?? 0) * ($i->quantity ?? 1)) ?? 0);
  $discount   = $order->discount   ?? 0;
  $shipping   = $order->shipping_cost ?? 0;
  $tax        = $order->tax        ?? 0;
  $grandTotal = $order->grand_total ?? max(0, $subtotal - $discount + $shipping + $tax);
@endphp

- Subtotal: **{{ Number::currency($subtotal, 'IDR') }}**  
@if(($discount ?? 0) > 0)- Diskon: **-{{ Number::currency($discount, 'IDR') }}**  
@endif
- Ongkos Kirim: **{{ Number::currency($shipping, 'IDR') }}**  
@if(($tax ?? 0) > 0)- Pajak: **{{ Number::currency($tax, 'IDR') }}**  
@endif
- **Total: {{ Number::currency($grandTotal, 'IDR') }}**

{{-- Alamat Pengiriman --}}
@if(!empty($order->shipping_address))
### Alamat Pengiriman
{{ $order->shipping_address['name'] ?? '' }}  
{{ $order->shipping_address['phone'] ?? '' }}  
{{ $order->shipping_address['address_line1'] ?? '' }}  
{{ $order->shipping_address['address_line2'] ?? '' }}  
{{ ($order->shipping_address['city'] ?? '') }}{{ !empty($order->shipping_address['city']) && !empty($order->shipping_address['postal_code']) ? ', ' : '' }}{{ $order->shipping_address['postal_code'] ?? '' }}  
{{ $order->shipping_address['province'] ?? '' }}
@endif

{{-- Metode --}}
@if(!empty($order->payment_method) || !empty($order->shipping_method))
### Metode
@isset($order->payment_method)- Pembayaran: **{{ $order->payment_method }}**  
@endisset
@isset($order->shipping_method)- Pengiriman: **{{ $order->shipping_method }}**  
@endisset
@endif

{{-- Tombol Aksi --}}
{{-- <x-mail::button :url="$url ?? url('/orders/'.($order->id ?? ''))">
Lihat Pesanan
</x-mail::button>

@isset($trackingUrl)
<x-mail::button :url="$trackingUrl" color="secondary">
Lacak Pengiriman
</x-mail::button>
@endisset

Jika tombol tidak berfungsi, salin dan tempel URL ini ke peramban Anda:  
{{ $url ?? url('/orders/'.($order->id ?? '')) }}
 --}}
---

Butuh bantuan? Balas email ini atau hubungi tim dukungan kami.

Terima kasih,  
**{{ config('app.name') }}**
</x-mail::message>
