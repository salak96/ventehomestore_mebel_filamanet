@php
  // Helper Rupiah tanpa desimal
  $rupiah = static function ($v): string {
      if ($v === null || $v === '') return 'Rp 0';
      return 'Rp ' . number_format((float) $v, 0, ',', '.');
  };

  // Ringkasan (silakan sesuaikan kalau ada pajak/ongkir)
  $subtotal = (float) ($grand_total ?? 0);
  $pajak    = 0;
  $ongkir   = 0;
  $total    = $subtotal + $pajak + $ongkir;
@endphp

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

    <!-- Header -->
    <div class="mb-6 rounded-xl bg-gradient-to-r from-teal-50 to-emerald-50 border border-teal-200 px-5 py-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Keranjang Belanja</h1>
                <p class="mt-1 text-gray-600">Tinjau pesanan Anda sebelum melanjutkan ke pembayaran.</p>
            </div>
            <a href="/products"
               class="inline-flex items-center gap-2 text-sm font-medium px-3 py-2 rounded-lg border border-teal-300 text-teal-700 bg-teal-50 hover:bg-teal-100">
                ← Lanjut Belanja
            </a>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-6">

        <!-- Daftar Item -->
        <div class="md:w-3/4">
            <div class="bg-white rounded-2xl shadow-sm border border-teal-200 overflow-hidden">

                <!-- Tabel (desktop) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-teal-50">
                            <tr class="text-left text-sm text-gray-600">
                                <th class="px-6 py-3 font-semibold">Produk</th>
                                <th class="px-6 py-3 font-semibold">Harga Satuan</th>
                                <th class="px-6 py-3 font-semibold">Kuantitas</th>
                                <th class="px-6 py-3 font-semibold">Total</th>
                                <th class="px-6 py-3 font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-teal-100">
                            @forelse ($cart_items as $cart_key => $item)
                                <tr wire:key="row-{{ $cart_key }}" class="align-top">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @php
                                              $img = $item['image'] ?? null;
                                              $imgUrl = $img ? storage_url($img) : asset('images/default.png');
                                            @endphp
                                            <img class="h-16 w-16 rounded-lg object-cover border border-teal-100"
                                                 src="{{ $imgUrl }}" alt="{{ $item['name'] }}">
                                            <div>
                                                <a href="/products/{{ $item['slug'] ?? '' }}"
                                                   class="font-semibold text-gray-800 hover:text-teal-700">
                                                    {{ $item['name'] }}
                                                </a>
                                                @if(!empty($item['variant_name']))
                                                    <div class="mt-1 text-xs text-gray-500">Varian: {{ $item['variant_name'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-gray-800 font-medium">
                                            {{ $rupiah($item['unit_amount']) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center rounded-xl border border-teal-200 overflow-hidden">
                                            <button wire:click="decreaseItem('{{ $cart_key }}')"
                                                    class="px-3 py-2 hover:bg-teal-50" aria-label="Kurangi jumlah">
                                                −
                                            </button>
                                            <span class="px-4 py-2 min-w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                                            <button wire:click="increaseItem('{{ $cart_key }}')"
                                                    class="px-3 py-2 hover:bg-teal-50" aria-label="Tambah jumlah">
                                                +
                                            </button>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-semibold text-emerald-700">
                                            {{ $rupiah($item['total_amount']) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <button wire:click="removeItem('{{ $cart_key }}')"
                                                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-red-200 text-red-700 bg-red-50 hover:bg-red-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-6 3h8" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16">
                                        <div class="text-center">
                                            <div class="mx-auto w-16 h-16 rounded-full bg-teal-50 flex items-center justify-center mb-4">🛒</div>
                                            <h3 class="text-xl font-semibold text-gray-700">Keranjang masih kosong</h3>
                                            <p class="mt-1 text-gray-500">Yuk, temukan furnitur impianmu.</p>
                                            <a href="/products"
                                               class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700">
                                                Mulai Belanja
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Kartu (mobile) -->
                <div class="md:hidden divide-y divide-teal-100">
                    @forelse ($cart_items as $cart_key => $item)
                        <div class="p-4" wire:key="card-{{ $cart_key }}">
                            <div class="flex gap-4">
                                @php
                                  $img = $item['image'] ?? null;
                                  $imgUrl = $img ? storage_url($img) : asset('images/default.png');
                                @endphp
                                <img class="h-20 w-20 rounded-lg object-cover border border-teal-100"
                                     src="{{ $imgUrl }}" alt="{{ $item['name'] }}">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <h3 class="font-semibold text-gray-800 line-clamp-2">{{ $item['name'] }}</h3>
                                        <button wire:click="removeItem('{{ $cart_key }}')"
                                                class="text-gray-500 hover:underline text-sm">Hapus</button>
                                    </div>
                                    @if(!empty($item['variant_name']))
                                        <div class="mt-1 text-xs text-gray-500">Varian: {{ $item['variant_name'] }}</div>
                                    @endif
                                    <div class="mt-1 text-sm text-gray-600">
                                        Harga:
                                        <span class="font-medium text-gray-800">{{ $rupiah($item['unit_amount']) }}</span>
                                    </div>
                                    <div class="mt-3 flex items-center justify-between">
                                        <div class="inline-flex items-center rounded-xl border border-teal-200 overflow-hidden">
                                            <button wire:click="decreaseItem('{{ $cart_key }}')" class="px-3 py-1.5 hover:bg-teal-50">-</button>
                                            <span class="px-4 py-1.5 min-w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                                            <button wire:click="increaseItem('{{ $cart_key }}')" class="px-3 py-1.5 hover:bg-teal-50">+</button>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-gray-500">Total</div>
                                            <div class="font-semibold text-emerald-700">
                                                {{ $rupiah($item['total_amount']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <h3 class="text-lg font-semibold text-gray-700">Keranjang masih kosong</h3>
                            <a href="/products"
                               class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700">
                                Mulai Belanja
                            </a>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        <!-- Ringkasan -->
        <div class="md:w-1/4">
            <div class="bg-white rounded-2xl shadow-sm border border-teal-200 p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Ringkasan</h2>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-800">{{ $rupiah($subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pajak</span>
                        <span class="font-medium text-gray-800">{{ $rupiah($pajak) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ongkos Kirim</span>
                        <span class="font-medium text-gray-800">{{ $rupiah($ongkir) }}</span>
                    </div>
                </div>

                <hr class="my-3">

                <div class="flex justify-between text-base">
                    <span class="font-semibold text-gray-800">Total</span>
                    <span class="font-bold text-emerald-700">{{ $rupiah($total) }}</span>
                </div>

                @if ($cart_items && count($cart_items) > 0)
                    <a href="/checkout"
                       class="mt-4 block text-center text-white font-semibold py-2.5 px-4 rounded-xl bg-teal-600 hover:bg-teal-700">
                        Lanjut ke Pembayaran
                    </a>
                @else
                    <button disabled
                            class="mt-4 w-full text-center font-semibold py-2.5 px-4 rounded-xl bg-gray-200 text-gray-500 cursor-not-allowed">
                        Keranjang Kosong
                    </button>
                @endif

                <!-- Info aman -->
                <div class="mt-4 text-xs text-gray-500">
                    Pembayaran aman &amp; terenkripsi. Kamu bisa meninjau detail pesanan di langkah berikutnya.
                </div>
            </div>
        </div>

    </div>
</div>
