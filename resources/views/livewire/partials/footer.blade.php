<footer class="w-full bg-slate-600 text-gray-300">
  <div class="w-full max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
    <!-- Accent top border -->
    <div class="h-1 w-full bg-gradient-to-r from-amber-500 via-orange-400 to-amber-500"></div>

    <div class="py-12 lg:pt-16">
      <!-- Grid -->
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
        <!-- Brand -->
        <div class="col-span-full lg:col-span-1">
          <a href="/" class="inline-flex items-center gap-2">
            <span class="inline-block w-2 h-2 rounded-full bg-amber-500"></span>
            <span class="text-xl font-semibold text-white">Ventehomestore</span>
          </a>
          <p class="mt-3 text-sm text-gray-400">
            Furnitur bergaya, kualitas tepercaya.
          </p>
        </div>

        <!-- Produk -->
        <div>
          <h4 class="font-semibold text-white">Produk</h4>
          <div class="mt-4 grid space-y-3">
            <p><a href="/categories" class="inline-flex gap-x-2 text-gray-400 hover:text-amber-400">Kategori</a></p>
            <p><a href="/products" class="inline-flex gap-x-2 text-gray-400 hover:text-amber-400">Semua Produk</a></p>
            <p><a href="/products?featured=1" class="inline-flex gap-x-2 text-gray-400 hover:text-amber-400">Produk Unggulan</a></p>
          </div>
        </div>

        <!-- Perusahaan -->
        <div>
          <h4 class="font-semibold text-white">Perusahaan</h4>
          <div class="mt-4 grid space-y-3">
            <p><a href="/about" class="inline-flex gap-x-2 text-gray-400 hover:text-amber-400">Tentang Kami</a></p>
            <p><a href="/blog" class="inline-flex gap-x-2 text-gray-400 hover:text-amber-400">Blog</a></p>
            <p><a href="/customers" class="inline-flex gap-x-2 text-gray-400 hover:text-amber-400">Pelanggan</a></p>
          </div>
        </div>

        <!-- Newsletter -->
        <div class="col-span-2">
          <h4 class="font-semibold text-white">Tetap Terhubung</h4>
          <p class="mt-1 text-sm text-gray-400">Dapatkan info produk & promo terbaru.</p>

          <form class="mt-4" action="#" method="post">
            <div class="flex flex-col items-stretch gap-2 sm:flex-row sm:items-center">
              <div class="w-full">
                <input
                  type="email"
                  name="newsletter_email"
                  placeholder="Masukkan email Anda"
                  class="w-full py-3 px-4 rounded-lg bg-slate-800/60 border border-slate-700 text-gray-200 placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                  required
                >
              </div>
              <button
                type="submit"
                class="w-full sm:w-auto whitespace-nowrap px-4 py-3 rounded-lg bg-amber-600 text-white font-semibold hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500"
              >
                Berlangganan
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- End Grid -->

      <!-- Bottom: centered copyright + social -->
      <div class="mt-10 sm:mt-12 flex flex-col items-center gap-4">
        <p class="text-sm text-gray-400 text-center">
          © 2024 Ventehomestore. Seluruh hak cipta dilindungi.
        </p>

        <div class="flex justify-center items-center gap-2">
          <a href="#" aria-label="Facebook"
             class="w-10 h-10 inline-flex justify-center items-center rounded-lg border border-slate-700 text-gray-200 hover:text-amber-400 hover:border-amber-500">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
              <path d="M16 8.049C16 3.603 12.418 0 8 0S0 3.603 0 8.049C0 12.066 2.926 15.396 6.75 16v-5.625H4.72V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258V8.05h2.218l-.354 2.326H9.25V16C13.074 15.396 16 12.066 16 8.049z"/>
            </svg>
          </a>

          <a href="#" aria-label="Tiktok"
             class="w-10 h-10 inline-flex justify-center items-center rounded-lg border border-slate-700 text-white hover:text-amber-400 hover:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/60">
            <svg class="w-5 h-5" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
              <path d="M9.588 0h2.276c.12 1.06.57 2.01 1.31 2.77.73.76 1.69 1.24 2.73 1.36v2.32a6.38 6.38 0 0 1-3.09-.86 6.7 6.7 0 0 1-1.2-.86v5.77A4.67 4.67 0 1 1 2.57 10.5a4.64 4.64 0 0 1 4.41-4.61c.25 0 .5.02.74.06v2.36c-.24-.08-.48-.12-.74-.12a2.31 2.31 0 1 0 2.31 2.31V0z"/>
            </svg>
          </a>

          <a href="#" aria-label="Youtube"
             class="w-10 h-10 inline-flex justify-center items-center rounded-lg border border-slate-700 text-white hover:text-amber-400 hover:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/60">
            <svg class="w-5 h-5" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
              <path d="M8.051 2h-.002C3.917 2 0 2.2 0 8s3.917 6 8.049 6h.002C12.083 14 16 13.8 16 8s-3.917-6-7.949-6zM6.4 10.667V5.333L10.667 8 6.4 10.667z"/>
            </svg>
          </a>

          <a href="#" aria-label="Instagram"
             class="w-10 h-10 inline-flex justify-center items-center rounded-lg border border-slate-700 text-white hover:text-amber-400 hover:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/60">
            <svg class="w-5 h-5" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
              <path d="M8 1.5c2.14 0 2.394.008 3.24.047.78.036 1.207.166 1.49.276.38.147.65.322.936.607.285.286.46.556.607.936.11.283.24.71.277 1.49.038.845.046 1.099.046 3.24s-.008 2.395-.046 3.24c-.037.78-.167 1.206-.277 1.49a2.73 2.73 0 0 1-.607.936 2.73 2.73 0 0 1-.936.607c-.283.11-.71.24-1.49.276-.846.039-1.1.047-3.24.047s-2.395-.008-3.24-.047c-.78-.036-1.207-.166-1.49-.276a2.73 2.73 0 0 1-.936-.607 2.73 2.73 0 0 1-.607-.936c-.11-.283-.24-.71-.276-1.49C1.508 10.394 1.5 10.14 1.5 8s.008-2.395.047-3.24c.036-.78.166-1.207.276-1.49.147-.38.322-.65.607-.936.286-.285.556-.46.936-.607.283-.11.71-.24 1.49-.276C5.605 1.508 5.86 1.5 8 1.5z"/>
              <path d="M8 4.5a3.5 3.5 0 1 0 0 7.001A3.5 3.5 0 0 0 8 4.5zm0 1.5a2 2 0 1 1 0 4.001 2 2 0 0 1 0-4zM11.5 4.25a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5z"/>
            </svg>
          </a>
        </div>
      </div>
      <!-- End Bottom -->
    </div>
  </div>
</footer>
