<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

  <!-- Header -->
  <div class="mb-8 rounded-xl bg-gradient-to-r from-teal-100 to-emerald-50 border border-teal-200 px-5 py-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
      <div>
        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Kategori</h1>
        <p class="mt-1 text-gray-600">Pilih kategori untuk mulai jelajahi produk favoritmu.</p>
      </div>

      <!-- (Opsional) Search kategori - aktifkan jika punya property Livewire: categorySearch -->
      {{-- <div class="relative">
        <input type="text" wire:model.live="categorySearch" placeholder="Cari kategori…"
               class="w-64 bg-white border border-teal-200 rounded-lg px-3 py-2 pl-9 focus:outline-none focus:ring-2 focus:ring-teal-400 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-200">
        <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/></svg>
      </div> --}}
    </div>
  </div>

  <!-- Grid Kategori -->
  <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">

    @foreach ($categories as $category)
      <a wire:key="cat-{{ $category->id }}" wire:navigate
         href="/products?selected_categories[0]={{ $category->id }}"
         class="group relative flex flex-col rounded-2xl overflow-hidden bg-white border border-teal-200 hover:shadow-md transition dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">

        <!-- Gambar -->
        <div class="aspect-[4/3] overflow-hidden bg-teal-50">
          <img src="{{ url('storage', $category->image) }}"
               alt="{{ $category->name }}"
               class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.04]"
               onerror="this.src='{{ asset('images/onlinetv.jpg') }}';">
          <!-- Overlay gradient ringan saat hover -->
          <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition bg-gradient-to-t from-black/20 via-black/5 to-transparent"></div>
        </div>

        <!-- Konten -->
        <div class="p-4 md:p-5">
          <div class="flex items-start justify-between gap-3">
            <h3 class="text-lg md:text-xl font-semibold text-gray-800 leading-snug group-hover:text-teal-700 dark:text-gray-200 dark:group-hover:text-gray-100">
              {{ $category->name }}
            </h3>

            <!-- Icon panah -->
            <span class="shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full bg-teal-50 text-teal-700 border border-teal-200 group-hover:bg-teal-100">
              <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>
              </svg>
            </span>
          </div>

          <!-- (Opsional) jumlah produk di kategori jika tersedia relasi/atribut products_count -->
          @if(isset($category->products_count))
            <div class="mt-2">
              <span class="inline-flex items-center text-xs font-semibold px-2 py-1 rounded-full bg-teal-100 text-teal-700">
                {{ $category->products_count }} produk
              </span>
            </div>
          @endif
        </div>

      </a>
    @endforeach

  </div>

  <!-- Empty state -->
  @if((is_iterable($categories) && count($categories) === 0) || ($categories instanceof \Illuminate\Pagination\LengthAwarePaginator && $categories->count() === 0))
    <div class="mt-10 text-center bg-white border border-teal-200 rounded-2xl p-10 dark:bg-gray-900 dark:border-gray-800">
      <p class="text-gray-600 dark:text-gray-300">Kategori belum tersedia.</p>
    </div>
  @endif

  <!-- Pagination (jika pakai paginate) -->
  @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="flex justify-end mt-8">
      {{ $categories->links() }}
    </div>
  @endif

</div>
