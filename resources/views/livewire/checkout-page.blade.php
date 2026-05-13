<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Checkout
    </h1>
    <form wire:submit.prevent="save">
        <div class="grid grid-cols-12 gap-4">
            <!-- Bagian Form Alamat -->
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        Data Pembeli
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Nama Depan -->
                        <div>
                            <label for="first_name" class="block text-gray-700 dark:text-white mb-1">Nama Depan</label>
                            <input id="first_name" type="text" wire:model="first_name"
                                class="w-full rounded-lg border @error('first_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                            @error('first_name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>

                        <!-- Nama Belakang -->
                        <div>
                            <label for="last_name" class="block text-gray-700 dark:text-white mb-1">Nama Belakang</label>
                            <input id="last_name" type="text" wire:model="last_name"
                                class="w-full rounded-lg border @error('last_name') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                            @error('last_name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Nomor HP -->
                    <div class="mt-4">
                        <label for="phone" class="block text-gray-700 dark:text-white mb-1">Nomor HP</label>
                        <input id="phone" type="text" wire:model="phone"
                            class="w-full rounded-lg border @error('phone') border-red-500 @enderror py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none">
                        @error('phone') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="text-lg font-semibold mt-6 mb-4">Pilih Metode Pembayaran</div>
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input class="hidden peer" type="radio" id="qris" value="qris" wire:model="payment_method" />
                            <label for="qris"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-teal-600 peer-checked:text-teal-600 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">QRIS</div>
                                    <div class="text-sm">Bayar pakai QRIS (GoPay, OVO, Dana, dll)</div>
                                </div>
                            </label>
                            @error('payment_method') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                        </li>

                        <li>
                            <input class="hidden peer" type="radio" id="stripe" value="stripe" wire:model="payment_method" />
                            <label for="stripe"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:border-teal-600 peer-checked:text-teal-600 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">Transfer Bank</div>
                                    <div class="text-sm">BCA, Mandiri, BRI, BNI</div>
                                </div>
                            </label>
                            @error('payment_method') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bagian Ringkasan -->
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        RINGKASAN PESANAN
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Subtotal</span>
                        <span>{{ formatRupiah($grand_total) }}</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Pajak</span>
                        <span>{{ formatRupiah(0) }}</span>
                    </div>
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Ongkir</span>
                        <span>{{ formatRupiah(0) }}</span>
                    </div>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
                    <div class="flex justify-between mb-2 font-bold">
                        <span>Total Bayar</span>
                        <span>{{ formatRupiah($grand_total) }}</span>
                    </div>
                </div>

                <!-- Tombol Simpan & WA -->
                <button type="button" wire:click="saveAndSendWhatsapp"
                    class="bg-green-600 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-700">
                    Simpan & Pesan via WhatsApp
                </button>

                <!-- Ringkasan Keranjang -->
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        RINGKASAN KERANJANG
                    </div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
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
                                        {{ formatRupiah($item['total_amount']) }}
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
    Livewire.on('open-whatsapp', (url) => {
        window.open(url, '_blank');
    });
});
</script>
