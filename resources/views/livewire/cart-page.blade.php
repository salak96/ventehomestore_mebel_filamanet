<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

  <!-- Header -->
  <div class="mb-6 rounded-xl bg-gradient-to-r from-amber-100 to-orange-50 border border-amber-200 px-5 py-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
      <div>
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Keranjang Belanja</h1>
        <p class="mt-1 text-gray-600">Tinjau pesanan Anda sebelum melanjutkan ke pembayaran.</p>
      </div>
      <a href="/products"
         class="inline-flex items-center gap-2 text-sm font-medium px-3 py-2 rounded-lg border border-amber-300 text-amber-700 bg-amber-50 hover:bg-amber-100">
        ← Lanjut Belanja
      </a>
    </div>
  </div>

  <div class="flex flex-col md:flex-row gap-6">

    <!-- Daftar Item -->
    <div class="md:w-3/4">
      <div class="bg-white rounded-2xl shadow-sm border border-amber-200 overflow-hidden">

        <!-- Tabel (desktop) -->
        <div class="hidden md:block overflow-x-auto">
          <table class="w-full">
            <thead class="bg-amber-50">
              <tr class="text-left text-sm text-gray-600">
                <th class="px-6 py-3 font-semibold">Produk</th>
                <th class="px-6 py-3 font-semibold">Harga Satuan</th>
                <th class="px-6 py-3 font-semibold">Kuantitas</th>
                <th class="px-6 py-3 font-semibold">Total</th>
                <th class="px-6 py-3 font-semibold">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-amber-100">
              @forelse ($cart_items as $item)
                <tr wire:key="row-{{ $item['product_id'] }}" class="align-top">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-4">
                      <img class="h-16 w-16 rounded-lg object-cover border border-amber-100"
                           src="{{ url('storage', $item['image']) }}"
                           alt="{{ $item['name'] }}">
                      <div>
                        <a href="/products/{{ $item['slug'] ?? '' }}" class="font-semibold text-gray-800 hover:text-amber-700">
                          {{ $item['name'] }}
                        </a>
                        @isset($item['variant'])
                          <div class="mt-1 text-xs text-gray-500">Varian: {{ $item['variant'] }}</div>
                        @endisset
                      </div>
                    </div>
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-gray-800 font-medium">
                      {{ Number::currency($item['unit_amount'], 'IDR') }}
                    </span>
                  </td>

                  <td class="px-6 py-4">
                    <div class="inline-flex items-center rounded-xl border border-amber-200 overflow-hidden">
                      <button wire:click="decreaseItem({{ $item['product_id'] }})"
                              class="px-3 py-2 hover:bg-amber-50"
                              aria-label="Kurangi jumlah">
                        −
                      </button>
                      <span class="px-4 py-2 min-w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                      <button wire:click="increaseItem({{ $item['product_id'] }})"
                              class="px-3 py-2 hover:bg-amber-50"
                              aria-label="Tambah jumlah">
                        +
                      </button>
                    </div>
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-semibold text-emerald-700">
                      {{ Number::currency($item['total_amount'], 'IDR') }}
                    </span>
                  </td>

                  <td class="px-6 py-4">
                    <button wire:click="removeItem({{ $item['product_id'] }})"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-red-200 text-red-700 bg-red-50 hover:bg-red-100">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-6 3h8"/>
                      </svg>
                      Hapus
                    </button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-6 py-16">
                    <div class="text-center">
                      <div class="mx-auto w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center mb-4">
                        🛒
                      </div>
                      <h3 class="text-xl font-semibold text-gray-700">Keranjang masih kosong</h3>
                      <p class="mt-1 text-gray-500">Yuk, temukan furnitur impianmu.</p>
                      <a href="/products"
                         class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">
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
        <div class="md:hidden divide-y divide-amber-100">
          @forelse ($cart_items as $item)
            <div class="p-4" wire:key="card-{{ $item['product_id'] }}">
              <div class="flex gap-4">
                <img class="h-20 w-20 rounded-lg object-cover border border-amber-100"
                     src="{{ url('storage', $item['image']) }}"
                     alt="{{ $item['name'] }}">
                <div class="min-w-0 flex-1">
                  <div class="flex items-start justify-between gap-3">
                    <h3 class="font-semibold text-gray-800 line-clamp-2">{{ $item['name'] }}</h3>
                    <button wire:click="removeItem({{ $item['product_id'] }})"
                            class="text-red-600 hover:underline text-sm">Hapus</button>
                  </div>
                  <div class="mt-1 text-sm text-gray-600">
                    Harga: <span class="font-medium text-gray-800">{{ Number::currency($item['unit_amount'], 'IDR') }}</span>
                  </div>
                  <div class="mt-3 flex items-center justify-between">
                    <div class="inline-flex items-center rounded-xl border border-amber-200 overflow-hidden">
                      <button wire:click="decreaseItem({{ $item['product_id'] }})" class="px-3 py-1.5 hover:bg-amber-50">−</button>
                      <span class="px-4 py-1.5 min-w-8 text-center font-medium">{{ $item['quantity'] }}</span>
                      <button wire:click="increaseItem({{ $item['product_id'] }})" class="px-3 py-1.5 hover:bg-amber-50">+</button>
                    </div>
                    <div class="text-right">
                      <div class="text-xs text-gray-500">Total</div>
                      <div class="font-semibold text-emerald-700">
                        {{ Number::currency($item['total_amount'], 'IDR') }}
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
                 class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-600 text-white hover:bg-amber-700">
                Mulai Belanja
              </a>
            </div>
          @endforelse
        </div>

      </div>
    </div>

    <!-- Ringkasan -->
    <div class="md:w-1/4">
      <div class="bg-white rounded-2xl shadow-sm border border-amber-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Ringkasan</h2>

        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-600">Subtotal</span>
            <span class="font-medium text-gray-800">{{ Number::currency($grand_total, 'IDR') }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Pajak</span>
            <span class="font-medium text-gray-800">{{ Number::currency(0, 'IDR') }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Ongkos Kirim</span>
            <span class="font-medium text-gray-800">{{ Number::currency(0, 'IDR') }}</span>
          </div>
        </div>

        <hr class="my-3">

        <div class="flex justify-between text-base">
          <span class="font-semibold text-gray-800">Total</span>
          <span class="font-bold text-emerald-700">{{ Number::currency($grand_total, 'IDR') }}</span>
        </div>

        @if ($cart_items && count($cart_items) > 0)
          <a href="/checkout"
             class="mt-4 block text-center text-white font-semibold py-2.5 px-4 rounded-xl bg-amber-600 hover:bg-amber-700">
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
          Pembayaran aman & terenkripsi. Kamu bisa meninjau detail pesanan di langkah berikutnya.
        </div>
      </div>
    </div>

  </div>
</div>
