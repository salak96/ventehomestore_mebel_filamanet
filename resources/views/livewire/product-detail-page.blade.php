@php
  // Helper Rupiah tanpa desimal
  $rupiah = static function ($v): string {
      if ($v === null || $v === '') return 'Rp 0';
      return 'Rp ' . number_format((float) $v, 0, ',', '.');
  };

  // Siapkan array URL gambar
  $rawImages = is_array($products->images ?? null) ? $products->images : (array) ($products->images ?? []);
  if (empty($rawImages)) {
      $rawImages = ['images/default.png'];
  }
  $imageUrls = [];
  foreach ($rawImages as $img) {
      $imageUrls[] = $img === 'images/default.png' ? asset($img) : url('storage', $img);
  }
@endphp

<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <section class="overflow-hidden bg-white py-11 font-poppins dark:bg-gray-800">
    <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
      <div class="flex flex-wrap -mx-4">

        {{-- Bagian Gambar Produk --}}
        <div class="w-full mb-8 md:w-1/2 md:mb-0"
             x-data="{ images: @js($imageUrls), i: 0 }">
          <div class="sticky top-24 z-10"> {{-- tidak menindih navbar --}}
            {{-- Gambar utama --}}
            <div class="relative mb-4 lg:mb-6">
              <div class="aspect-[4/3] w-full overflow-hidden rounded-2xl bg-gray-50">
                <img :src="images[i]"
                     alt="{{ $products->name ?? 'Produk' }}"
                     class="w-full h-full object-contain md:object-cover select-none"
                     loading="lazy" decoding="async"
                     onerror="this.onerror=null;this.src='{{ asset('images/default.png') }}';">
              </div>
            </div>

            {{-- Thumbnail: desktop (grid) --}}
            <div class="hidden md:grid grid-cols-4 gap-3">
              @foreach ($imageUrls as $idx => $src)
                        <button type="button"
                        class="relative aspect-square overflow-hidden rounded-xl bg-white border border-teal-200"
                        @click="i={{ $idx }}">
                  <img src="{{ $src }}"
                       alt="Thumbnail {{ $idx + 1 }} - {{ $products->name ?? 'Produk' }}"
                       class="w-full h-full object-cover"
                       loading="lazy"
                       onerror="this.onerror=null;this.src='{{ asset('images/default.png') }}';">
                  <span class="pointer-events-none absolute inset-0 rounded-xl"
                        :class="i==={{ $idx }} ? 'ring-2 ring-teal-500' : 'ring-1 ring-transparent'"></span>
                </button>
              @endforeach
            </div>

            {{-- Thumbnail: mobile (scroll-snap) --}}
            <div class="md:hidden mt-3 overflow-x-auto -mx-1 px-1">
              <div class="flex gap-3 snap-x snap-mandatory">
                @foreach ($imageUrls as $idx => $src)
                  <button type="button"
                          class="relative min-w-20 w-20 aspect-square overflow-hidden rounded-xl bg-white border border-teal-200 snap-start"
                          @click="i={{ $idx }}">
                    <img src="{{ $src }}"
                         alt="Thumb {{ $idx + 1 }} - {{ $products->name ?? 'Produk' }}"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='{{ asset('images/default.png') }}';">
                    <span class="pointer-events-none absolute inset-0 rounded-xl"
                          :class="i==={{ $idx }} ? 'ring-2 ring-teal-500' : 'ring-1 ring-transparent'"></span>
                  </button>
                @endforeach
              </div>
            </div>

            {{-- Info tambahan --}}
            <div class="px-6 pb-6 mt-6 border-t border-gray-200 dark:border-gray-700">
              <div class="flex items-center gap-2 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Gratis Ongkir</h2>
              </div>
            </div>
          </div>
        </div>

        {{-- Bagian Detail Produk --}}
        <div class="w-full px-4 md:w-1/2">
          <div class="lg:pl-20">
            {{-- Nama & Harga --}}
            <div class="mb-8">
              <h1 class="max-w-xl mb-3 text-2xl md:text-4xl font-bold text-gray-900 dark:text-gray-100">
                {{ $products->name }}
              </h1>
              <p class="inline-block mb-4 text-3xl md:text-4xl font-bold text-emerald-700">
                {{ $rupiah($products->price) }}
              </p>
              <div class="prose prose-sm md:prose-base dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                {!! Str::markdown($products->description) !!}
              </div>
            </div>

            {{-- Jumlah Produk --}}
            <div class="mb-8">
              <label class="block pb-1 text-sm font-semibold text-gray-700 dark:text-gray-300">
                Jumlah
              </label>
              <div class="inline-flex items-stretch mt-2 rounded-xl border border-gray-300 dark:border-gray-700 overflow-hidden">
                <button wire:click="decreaseQty"
                        class="px-3 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                        aria-label="Kurangi jumlah">−</button>
                <input type="number" wire:model="quantity" readonly
                       class="w-14 text-center font-semibold bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 focus:outline-none"
                       aria-label="Jumlah" />
                <button wire:click="increaseQty"
                        class="px-3 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                        aria-label="Tambah jumlah">+</button>
              </div>
            </div>

            {{-- Tombol Tambah ke Keranjang --}}
            <div class="flex flex-wrap items-center gap-3">
              <button wire:click="addToCart({{ $products->id }})"
                      class="w-full sm:w-auto px-6 py-3 rounded-xl bg-teal-600 text-white font-semibold hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-400">
                <span wire:loading.remove wire:target="addToCart({{ $products->id }})">Tambah ke Keranjang</span>
                <span wire:loading wire:target="addToCart({{ $products->id }})">Menambahkan…</span>
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
