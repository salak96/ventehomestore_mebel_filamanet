<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Checkout
    </h1>
    <form wire:submit.prevent="save">
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
                                <input wire:model="first_name"
                                    class="w-full rounded-lg border @error('first_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    id="first_name" type="text">
                                </input>
                                @error('first_name')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="last_name">
                                    Nama Belakang
                                </label>
                                <input wire:model="last_name"
                                    class="w-full rounded-lg border @error('last_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    id="last_name" type="text">
                                </input>
                                @error('last_name')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="phone">
                                Nomor HP
                            </label>
                            <input wire:model="phone"
                                class="w-full rounded-lg border @error('phone') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                id="phone" type="text">
                            </input>
                            @error('phone')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="address">
                                Alamat Lengkap
                            </label>
                            <input wire:model="address"
                                class="w-full rounded-lg border @error('address') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                id="address" type="text">
                            </input>
                            @error('address')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="block text-gray-700 dark:text-white mb-1" for="city">
                                Kota
                            </label>
                            <input wire:model="city"
                                class="w-full rounded-lg border @error('city') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                id="city" type="text">
                            </input>
                            @error('city')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="state">
                                    Provinsi
                                </label>
                                <input wire:model="state"
                                    class="w-full rounded-lg border @error('state') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    id="state" type="text">
                                </input>
                                @error('state')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-white mb-1" for="zip">
                                    Kode Pos
                                </label>
                                <input wire:model="zip_code"
                                    class="w-full rounded-lg border @error('zip_code') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none"
                                    id="zip" type="text">
                                </input>
                                @error('zip_code')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="text-lg font-semibold mb-4">
                        Pilih Metode Pembayaran
                    </div>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input class="hidden peer" wire:model="payment_method" id="cod" value="cod"
                                type="radio" />
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="cod">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Bayar di Tempat (COD)
                                    </div>
                                </div>
                            </label>
                            @error('payment_method')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </li>
                        <li>
                            <input class="hidden peer" wire:model="payment_method" value="stripe" id="stripe"
                                type="radio">
                            <label
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700"
                                for="stripe">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">
                                        Transfer Bank
                                    </div>
                                </div>
                            </label>
                            </input>
                            @error('payment_method')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                        </li>
                    </ul>
                </div>
                <!-- End Card -->
            </div>
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        RINGKASAN PESANAN
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Subtotal</span>
                        <span>{{ Number::currency($grand_total, 'IDR') }}</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Pajak</span>
                        <span>{{ Number::currency(0, 'IDR') }}</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Ongkir</span>
                        <span>{{ Number::currency(0, 'IDR') }}</span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Total Bayar</span>
                        <span>{{ Number::currency($grand_total, 'IDR') }}</span>
                    </div>
                </div>
             <button type="button"
    wire:click="orderViaWhatsapp"
    class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
    Pesan via WhatsApp
</button>

                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        RINGKASAN KERANJANG
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach ($cart_items as $item)
                            <li class="py-3 sm:py-4" wire:key="{{ $item['product_id'] }}">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img alt="{{ $item['name'] }}" class="w-12 h-12 rounded-full"
                                            src="{{ url('storage', $item['image']) }}">
                                        </img>
                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $item['name'] }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            Jumlah: {{ $item['quantity'] }}
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        {{ Number::currency($item['total_amount'], 'IDR') }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('open-whatsapp', (event) => {
        window.open(event.url, '_blank');
    });
});
</script>
