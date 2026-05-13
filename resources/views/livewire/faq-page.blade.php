<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white">Frequently Asked <span class="text-teal-600">Questions</span></h1>
            <div class="flex w-40 mt-2 mb-6 mx-auto overflow-hidden rounded">
                <div class="flex-1 h-2 bg-teal-200"></div>
                <div class="flex-1 h-2 bg-teal-400"></div>
                <div class="flex-1 h-2 bg-teal-600"></div>
            </div>
            <p class="text-gray-500">Pertanyaan yang sering diajukan seputar AndroidStore.</p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">

            <!-- FAQ 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Apa itu firmware STB?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    Firmware STB adalah perangkat lunak sistem yang mengoperasikan Set Top Box. Firmware yang kami sediakan sudah teruji dan siap flashing untuk berbagai merek STB seperti Nexmedia, Evercoss, Matrix, dan lainnya.
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Bagaimana cara flashing firmware?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    Setelah membeli firmware, Anda akan mendapatkan link download beserta panduan flashing. Proses flashing dilakukan menggunakan PC/laptop dengan software khusus tergantung tipe STB. Jika mengalami kesulitan, tim kami siap membantu.
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Apa itu jasa root?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    Root adalah proses mendapatkan akses superuser/administrator pada perangkat Android. Dengan root, Anda bisa menginstall custom ROM, menghapus bloatware, meningkatkan performa, dan melakukan kustomisasi sistem secara mendalam.
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Apakah root aman?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    Ya, root yang dilakukan oleh tim profesional kami aman. Kami menggunakan metode terbaru dan terpercaya. Namun perlu diketahui bahwa root dapat membatalkan garansi pabrik perangkat Anda.
                </div>
            </div>

            <!-- FAQ 5 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Bagaimana cara mendapatkan produk digital?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    Produk digital seperti template CapCut, Canva, dan akun Netflix akan dikirimkan secara otomatis setelah pembayaran berhasil melalui email/WhatsApp yang terdaftar.
                </div>
            </div>

            <!-- FAQ 6 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Apa saja metode pembayaran yang tersedia?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    Kami menerima pembayaran melalui transfer bank (BCA, Mandiri, BRI, BNI), e-wallet (GoPay, OVO, Dana, LinkAja), dan Cash on Demand (COD) untuk area tertentu.
                </div>
            </div>

            <!-- FAQ 7 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Berapa lama proses pengiriman?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    <strong>Produk digital:</strong> Instan (1-5 menit setelah pembayaran).<br>
                    <strong>Firmware/Custom ROM:</strong> Link download dikirim 1-24 jam.<br>
                    <strong>Jasa Root:</strong> Proses 1-2 jam, tergantung antrian.
                </div>
            </div>

            <!-- FAQ 8 -->
            <div class="bg-white rounded-2xl shadow-sm border border-teal-100 overflow-hidden" x-data="{ open: false }">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between p-6 text-left">
                    <span class="font-semibold text-gray-800 text-lg">Bagaimana jika ada masalah dengan produk?</span>
                    <svg class="w-5 h-5 text-teal-600 transition-transform" :class="open ? 'rotate-180' : ''"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                    Hubungi kami segera via WhatsApp. Tim support kami siap membantu 24 jam. Untuk produk digital bermasalah, kami akan bantu reset atau ganti dengan yang baru.
                </div>
            </div>

        </div>

        <div class="mt-12 text-center bg-teal-50 rounded-2xl p-8 border border-teal-100">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Masih punya pertanyaan?</h3>
            <p class="text-gray-500 mb-4">Jangan ragu untuk menghubungi tim support kami.</p>
            <a href="https://wa.me/6285642268279" target="_blank"
                class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi WhatsApp
            </a>
        </div>
    </div>
</div>
