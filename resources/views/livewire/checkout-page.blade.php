@php
  // Helper format rupiah: tanpa desimal
  $rupiah = static function ($v): string {
      $v = (float) $v;
      return 'Rp ' . number_format($v, 0, ',', '.');
  };

  // Ringkasan biaya (ubah kalau perlu)
  $pajak     = 0;
  $ongkir    = 0;
  $subtotal  = (float) ($grand_total ?? 0);
  $totalAkhir = $subtotal + $pajak + $ongkir;

  // WhatsApp nota
  $nota = "Halo, saya ingin memesan:\n\n";
  foreach ($cart_items as $item) {
      $nota .= "- {$item['name']} ({$item['quantity']}x) = " . $rupiah($item['total_amount']) . "\n";
  }
  $nota .= "\nTotal: " . $rupiah($totalAkhir);
  $whatsappLink = "https://wa.me/6285780020873?text=" . urlencode($nota);
@endphp

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Checkout</h1>

  <div class="grid grid-cols-12 gap-4">
    <!-- Kiri: Form Alamat + Metode Pembayaran -->
    <div class="col-span-12 lg:col-span-8">
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <!-- Alamat Pengiriman -->
        <div class="mb-6">
          <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">Alamat Pengiriman</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="first_name" class="block text-gray-700 dark:text-white mb-1">Nama Depan</label>
              <input id="first_name" type="text" wire:model="first_name"
                     class="w-full rounded-lg border @error('first_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
              @error('first_name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="last_name" class="block text-gray-700 dark:text-white mb-1">Nama Belakang</label>
              <input id="last_name" type="text" wire:model="last_name"
                     class="w-full rounded-lg border @error('last_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
              @error('last_name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mt-4">
            <label for="phone" class="block text-gray-700 dark:text-white mb-1">No. Telepon</label>
            <input id="phone" type="text" wire:model="phone"
                   class="w-full rounded-lg border @error('phone') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
            @error('phone') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
          </div>

          <div class="mt-4">
            <label for="address" class="block text-gray-700 dark:text-white mb-1">Alamat Lengkap</label>
            <input id="address" type="text" wire:model="address"
                   class="w-full rounded-lg border @error('address') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
            @error('address') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
          </div>

          <div class="mt-4">
            <label for="city" class="block text-gray-700 dark:text-white mb-1">Kota</label>
            <input id="city" type="text" wire:model="city"
                   class="w-full rounded-lg border @error('city') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
            @error('city') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
              <label for="state" class="block text-gray-700 dark:text-white mb-1">Provinsi</label>
              <input id="state" type="text" wire:model="state"
                     class="w-full rounded-lg border @error('state') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
              @error('state') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div>
              <label for="zip" class="block text-gray-700 dark:text-white mb-1">Kode Pos</label>
              <input id="zip" type="text" wire:model="zip_code"
                     class="w-full rounded-lg border @error('zip_code') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
              @error('zip_code') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="text-lg font-semibold mb-4">Metode Pembayaran</div>
        <ul class="grid w-full gap-4 md:grid-cols-2">
          <li>
            <input class="hidden peer" id="cod" type="radio" value="cod" wire:model="payment_method" />
            <label for="cod"
                   class="inline-flex items-center justify-between w-full p-5 text-gray-600 bg-white border border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:bg-gray-100 dark:bg-gray-800">
              <span class="w-full text-lg font-semibold">Bayar di Tempat</span>
            </label>
          </li>
          <li>
            <input class="hidden peer" id="transfer" type="radio" value="transfer" wire:model="payment_method" />
            <label for="transfer"
                   class="inline-flex items-center justify-between w-full p-5 text-gray-600 bg-white border border-gray-200 rounded-lg cursor-pointer dark:border-gray-700 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:bg-gray-100 dark:bg-gray-800">
              <span class="w-full text-lg font-semibold">Transfer Bank</span>
            </label>
          </li>
        </ul>
      </div>
    </div>

    <!-- Kanan: Keranjang + Ringkasan -->
    <div class="col-span-12 lg:col-span-4 space-y-4">
      <!-- Keranjang -->
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">Detail Keranjang</div>

        <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
          @foreach ($cart_items as $item)
            <li class="py-3 sm:py-4" wire:key="{{ $item['product_id'] }}">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  @php
                    $img = $item['image'] ?? null;
                    $imgUrl = $img ? url('storage', $img) : asset('images/default.png');
                  @endphp
                  <img src="{{ $imgUrl }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-full object-cover">
                </div>
                <div class="flex-1 min-w-0 ms-4">
                  <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ $item['name'] }}</p>
                  <p class="text-sm text-gray-500 truncate dark:text-gray-400">Jumlah: {{ $item['quantity'] }}</p>
                </div>
                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                  {{ $rupiah($item['total_amount']) }}
                </div>
              </div>
            </li>
          @endforeach
        </ul>
      </div>

      <!-- Ringkasan Pesanan -->
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">Ringkasan Pesanan</div>

        <div class="flex justify-between mb-2 font-bold">
          <span>Subtotal</span>
          <span>{{ $rupiah($subtotal) }}</span>
        </div>
        <div class="flex justify-between mb-2 font-bold">
          <span>Pajak</span>
          <span>{{ $rupiah($pajak) }}</span>
        </div>
        <div class="flex justify-between mb-2 font-bold">
          <span>Ongkir</span>
          <span>{{ $rupiah($ongkir) }}</span>
        </div>

        <hr class="bg-slate-400 my-4 h-[2px] rounded">

        <div class="flex justify-between mb-2 font-bold text-lg">
          <span>Total Akhir</span>
          <span>{{ $rupiah($totalAkhir) }}</span>
        </div>

        <!-- Tombol ke WhatsApp -->
        <a href="{{ $whatsappLink }}" target="_blank"
           class="bg-green-500 mt-4 w-full block text-center p-3 rounded-lg text-lg text-white hover:bg-green-600">
          Pesan via WhatsApp
        </a>
      </div>
    </div>
  </div>
</div>
@push('styles')
  <style>
    /* Sesuaikan gaya input radio */
    input[type="radio"]:checked + label {
      border-color: #3b82f6; /* Biru */
      background-color: #eff6ff; /* Biru muda */
    }
  </style>
@endpush