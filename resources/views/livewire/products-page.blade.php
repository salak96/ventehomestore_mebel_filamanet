@php
  // Helper Rupiah tanpa desimal
  $rupiah = static function ($v): string {
      if ($v === null || $v === '') return 'Rp 0';
      return 'Rp ' . number_format((float) $v, 0, ',', '.');
  };
@endphp

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

    <!-- Header / Toolbar -->
    <div class="mb-6 rounded-xl bg-gradient-to-r from-teal-50 to-emerald-50 border border-teal-200 px-4 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Katalog Produk</h2>
                <p class="text-gray-600 mt-1">
                    Temukan firmware STB, custom ROM, dan produk digital terbaru.
                </p>
            </div>

            <!-- Filter, Sort, Search, Reset -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                    <!-- Search -->
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live.debounce.500ms="search"
                            placeholder="Cari produk…"
                            class="w-64 sm:w-72 bg-white border border-teal-200 rounded-lg px-9 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200"
                            aria-label="Cari produk">

                        <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                        </svg>

                        <!-- Tombol clear -->
                        @if (!empty($search))
                            <button type="button" wire:click="$set('search','')"
                                    class="absolute right-2.5 top-2 inline-flex items-center justify-center w-6 h-6 rounded hover:bg-teal-100 text-gray-500"
                                    aria-label="Bersihkan pencarian" title="Bersihkan">&times;</button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Sort -->
                <select
                    wire:model.live.change="sort"
                    class="block w-48 text-sm sm:text-base bg-white border border-teal-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300">
                    <option value="latest">Urutkan: Terbaru</option>
                    <option value="price">Urutkan: Harga</option>
                </select>

                <!-- Reset Filter -->
                <a href="/products"
                   class="inline-flex items-center text-sm font-medium px-3 py-2 rounded-lg border border-teal-300 text-teal-700 bg-teal-50 hover:bg-teal-100 dark:border-gray-700 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                    Reset Filter
                </a>
            </div>
        </div>

        <!-- Info jumlah hasil -->
        <div class="mt-3 text-sm text-gray-500">
            @php $total = method_exists($products, 'total') ? $products->total() : count($products); @endphp
            Menampilkan <span class="font-semibold text-gray-700">{{ $total }}</span> produk
        </div>
    </div>

    <section class="font-poppins rounded-lg">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-wrap gap-6 lg:gap-8 mb-10">

                <!-- Sidebar -->
                <aside class="w-full lg:w-1/4 shrink-0">
                    <div class="sticky top-6 space-y-5">

                        <!-- Categories -->
                        <div class="p-5 bg-white border border-teal-200 rounded-2xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Kategori</h3>
                            <div class="mt-2 w-16 h-1 rounded bg-teal-400"></div>

                            <ul class="mt-5 space-y-3">
                                @foreach ($categories as $category)
                                    <li wire:key="cat-{{ $category->id }}">
                                        <label for="cat-{{ $category->slug }}" class="group flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" id="cat-{{ $category->slug }}"
                                                   value="{{ $category->id }}" wire:model.live.change="selected_categories"
                                                   class="peer size-4 accent-teal-600 rounded border-gray-300 focus:ring-teal-400">
                                            <span class="text-base text-gray-700 group-hover:text-teal-700 dark:text-gray-300 dark:group-hover:text-gray-100">
                                                {{ $category->name }}
                                            </span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Brand -->
                        <div class="p-5 bg-white border border-teal-200 rounded-2xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Merek</h3>
                            <div class="mt-2 w-16 h-1 rounded bg-teal-400"></div>

                            <ul class="mt-5 grid grid-cols-1 gap-3">
                                @foreach ($brands as $brand)
                                    <li wire:key="brand-{{ $brand->id }}">
                                        <label for="brand-{{ $brand->slug }}" class="group inline-flex items-center gap-3 cursor-pointer">
                                            <input type="checkbox" id="brand-{{ $brand->slug }}"
                                                   value="{{ $brand->id }}" wire:model.live.change="selected_brands"
                                                   class="peer size-4 accent-teal-600 rounded border-gray-300 focus:ring-teal-400">
                                            <span class="text-base text-gray-700 group-hover:text-teal-700 dark:text-gray-300 dark:group-hover:text-gray-100">
                                                {{ $brand->name }}
                                            </span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Status -->
                        <div class="p-5 bg-white border border-teal-200 rounded-2xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Status Produk</h3>
                            <div class="mt-2 w-16 h-1 rounded bg-teal-400"></div>

                            <ul class="mt-5 space-y-3">
                                <li>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model.live.change="featured"
                                               class="size-4 accent-teal-600 rounded border-gray-300 focus:ring-teal-400">
                                        <span class="text-base text-gray-700 dark:text-gray-300">Produk Unggulan</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model.live.change="onSale"
                                               class="size-4 accent-teal-600 rounded border-gray-300 focus:ring-teal-400">
                                        <span class="text-base text-gray-700 dark:text-gray-300">Sedang Diskon</span>
                                    </label>
                                </li>
                            </ul>
                        </div>

                        <!-- Price -->
                        <div class="p-5 bg-white border border-teal-200 rounded-2xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">Harga</h3>
                            <div class="mt-2 w-16 h-1 rounded bg-teal-400"></div>

                            <div class="mt-5">
                                <input
                                    type="range"
                                    wire:model.live.debounce.500ms="price_range"
                                    max="5000000"
                                    step="100000"
                                    class="w-full h-2 bg-teal-100 rounded-lg appearance-none cursor-pointer">
                                <div class="mt-3 flex items-center justify-between text-sm">
                                    <span class="inline-flex items-center gap-1 font-semibold text-teal-700 bg-teal-50 px-2 py-1 rounded">
                                        {{ $rupiah($price_range) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 font-semibold text-teal-700 bg-teal-50 px-2 py-1 rounded">
                                        {{ $rupiah(5000000) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </aside>
                <!-- /Sidebar -->

                <!-- Product Grid -->
                <main class="min-w-0 flex-1 lg:w-3/4">
                    <!-- Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 md:gap-6">

                        @foreach ($products as $product)
                            <div
                                livewire:key="prod-{{ $product->id }}"
                                class="group relative bg-white border border-teal-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all dark:bg-gray-900 dark:border-gray-800">

                                <!-- Badge -->
                                <div class="absolute z-10 left-3 top-3 flex flex-col gap-2">
                                    @isset($product->on_sale)
                                        @if ($product->on_sale || (!empty($onSale) && $onSale))
                                            <span class="inline-flex items-center text-[11px] font-semibold px-2 py-1 rounded-full bg-rose-100 text-rose-700">
                                                Diskon
                                            </span>
                                        @endif
                                    @endisset
                                    @isset($product->featured)
                                        @if ($product->featured || (!empty($featured) && $featured))
                                            <span class="inline-flex items-center text-[11px] font-semibold px-2 py-1 rounded-full bg-teal-100 text-teal-700">
                                                Unggulan
                                            </span>
                                        @endif
                                    @endisset
                                </div>

                                <!-- Image -->
                                @php
                                  $img = is_array($product->images ?? null) && !empty($product->images) ? $product->images[0] : null;
                                  $imgUrl = $img ? url('storage', $img) : asset('images/default.png');
                                @endphp
                                <a href="/products/{{ $product->slug }}" wire:navigate class="block bg-gray-50">
                                    <div class="aspect-[4/3] overflow-hidden">
                                        <img
                                            src="{{ $imgUrl }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-[1.03]"
                                            onerror="this.src='{{ asset('images/onlinetv.jpg') }}';">
                                    </div>
                                </a>

                                <!-- Content -->
                                <div class="p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <h3 class="text-lg font-semibold text-gray-800 leading-snug dark:text-gray-200">
                                            {{ $product->name }}
                                        </h3>
                                    </div>

                                    <div class="mt-2">
                                        <p class="text-base">
                                            <span class="text-emerald-700 font-bold">
                                                {{ $rupiah($product->price) }}
                                            </span>
                                            @isset($product->compare_at_price)
                                                @if ($product->compare_at_price > $product->price)
                                                    <span class="ml-2 text-sm line-through text-gray-400">
                                                        {{ $rupiah($product->compare_at_price) }}
                                                    </span>
                                                @endif
                                            @endisset
                                        </p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="px-4 pb-4">
                                    <button
                                        wire:click.prevent="addToCart({{ $product->id }})"
                                        class="w-full inline-flex items-center justify-center gap-2 text-sm font-semibold rounded-xl border border-transparent bg-teal-600 text-white py-2.5 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400 disabled:opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2l.5 2H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.4.472L4.4 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.49-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                        </svg>
                                        <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Tambah ke Keranjang</span>
                                        <span wire:loading wire:target="addToCart({{ $product->id }})">Menambahkan…</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Empty state -->
                    @if (
                        ($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->count() === 0) ||
                        (is_iterable($products) && count($products) === 0)
                    )
                        <div class="mt-10 text-center bg-white border border-teal-200 rounded-2xl p-10 dark:bg-gray-900 dark:border-gray-800">
                            <p class="text-gray-600 dark:text-gray-300">Produk tidak ditemukan. Coba ubah filter atau kata kunci.</p>
                        </div>
                    @endif

                    <!-- Pagination -->
                    <div class="flex justify-end mt-8">
                        {{ $products->links() }}
                    </div>
                </main>
                <!-- /Product Grid -->

            </div>
        </div>
    </section>
</div>
