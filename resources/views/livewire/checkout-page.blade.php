@php
  $rp = fn ($v) => 'Rp ' . number_format((float) $v, 0, ',', '.');
@endphp
<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Checkout
    </h1>

    <div class="grid grid-cols-12 gap-4">
        <div class="md:col-span-12 lg:col-span-8 col-span-12">
            <!-- Card -->
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <!-- Alamat Pengiriman -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        Alamat Pengiriman
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="first_name">
                                Nama Depan
                            </label>
                            <input wire:model="first_name" id="first_name" type="text"
                                class="w-full rounded-lg border @error('first_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                            @error('first_name')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                Nama Belakang
                            </label>
                            <input wire:model="last_name" id="last_name" type="text"
                                class="w-full rounded-lg border @error('last_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                            @error('last_name')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white mb-1" for="phone">No. Telepon</label>
                        <input wire:model="phone" id="phone" type="text"
                            class="w-full rounded-lg border @error('phone') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                        @error('phone')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white mb-1" for="address">Alamat Lengkap</label>
                        <input wire:model="address" id="address" type="text"
                            class="w-full rounded-lg border @error('address') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                        @error('address')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white mb-1" for="city">Kota</label>
                        <input wire:model="city" id="city" type="text"
                            class="w-full rounded-lg border @error('city') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                        @error('city')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="state">Provinsi</label>
                            <input wire:model="state" id="state" type="text"
                                class="w-full rounded-lg border @error('state') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                            @error('state')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="zip">Kode Pos</label>
                            <input wire:model="zip_code" id="zip" type="text"
                                class="w-full rounded-lg border @error('zip_code') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                            @error('zip_code')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
             <div class="text-lg font-semibold mb-4">Metode Pembayaran</div>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                    <li class="list-none">
                        <input
                        class="hidden peer"
                        wire:model="payment_method"
                        id="cod"
                        name="payment_method"
                        value="cod"
                        type="radio"
                        />
                        <label for="cod"
                        class="inline-flex items-center justify-between w-full p-5 rounded-lg cursor-pointer
                                border border-gray-200 bg-white text-gray-500
                                dark:bg-gray-800 dark:border-gray-700

                                hover:text-orange-600 hover:border-orange-500 hover:bg-orange-100
                                dark:hover:text-orange-400 dark:hover:bg-orange-900/30

                                peer-checked:text-orange-700 peer-checked:border-orange-600 peer-checked:bg-orange-50
                                transition-colors duration-150 ease-out">
                        <span class="w-full text-lg font-semibold">Bayar di Tempat</span>
                        </label>
                    </li>

                    <li class="list-none">
                        <input
                        class="hidden peer"
                        wire:model="payment_method"
                        id="transfer"
                        name="payment_method"
                        value="transfer"
                        type="radio"
                        />
                        <label for="transfer"
                        class="inline-flex items-center justify-between w-full p-5 rounded-lg cursor-pointer
                                border border-gray-200 bg-white text-gray-500
                                dark:bg-gray-800 dark:border-gray-700

                                hover:text-orange-600 hover:border-orange-500 hover:bg-orange-100
                                dark:hover:text-orange-400 dark:hover:bg-orange-900/30

                                peer-checked:text-orange-700 peer-checked:border-orange-600 peer-checked:bg-orange-50
                                transition-colors duration-150 ease-out">
                        <span class="w-full text-lg font-semibold">Transfer Bank</span>
                        </label>
                    </li>
                    </ul>
                @error('payment_method')
                    <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                @enderror

            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="md:col-span-12 lg:col-span-4 col-span-12">
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                    Ringkasan Pesanan
                </div>
                <div class="flex justify-between mb-2 font-bold ">
                    <span>Subtotal</span>
                     <span>{{ $rp($grand_total) }}</span>
                </div>
                <div class="flex justify-between mb-2 font-bold">
                    <span>Pajak</span>
                      <span>{{ $rp(0) }}</span>
                </div>
                <div class="flex justify-between mb-2 font-bold">
                    <span>Ongkir</span>
                      <span>{{ $rp(0) }}</span>
                </div>
                <hr class="bg-slate-400 my-4 h-1 rounded">
                <div class="flex justify-between mb-2 font-bold">
                    <span>Total Akhir</span>
                  <span>{{ $rp($grand_total) }}</span>
                </div>
            </div>

            <!-- Tombol ke WhatsApp -->
            @php
                $nota = "Halo, saya ingin memesan:\n\n";
                foreach ($cart_items as $item) {
                    $nota .=
                        "- {$item['name']} ({$item['quantity']}x) = Rp" .
                        number_format($item['total_amount'], 0, ',', '.') .
                        "\n";
                }
                $nota .= "\nTotal: Rp" . number_format($grand_total, 0, ',', '.');
                $whatsappLink = 'https://wa.me/6285780020873?text=' . urlencode($nota);
            @endphp

            <a href="{{ $whatsappLink }}" target="_blank"
                class="bg-green-500 mt-4 w-full block text-center p-3 rounded-lg text-lg text-white hover:bg-green-600">
                Pesan via WhatsApp
            </a>

            <!-- Keranjang -->
            <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                    Detail Keranjang
                </div>
                <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                    @foreach ($cart_items as $item)
                        <li class="py-3 sm:py-4" wire:key="{{ $item['product_id'] }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ url('storage', $item['image']) }}" alt="{{ $item['name'] }}"
                                        class="w-12 h-12 rounded-full">
                                </div>
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $item['name'] }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        Jumlah: {{ $item['quantity'] }}
                                    </p>
                                </div>
                               <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $rp($item['total_amount']) }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
