<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    @vite(['resources/css/app.css'])
    <style>
        [x-cloak] { display: none !important; }
        
        /* Animasi melayang untuk logo 404 */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-200 dark:bg-slate-700">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl mx-auto text-center">
            
            <!-- BAGIAN LOGO 404 -->
            <div class="flex justify-center mb-6 animate-float">
                <!-- Opsi 1: Menggunakan Icon SVG (Bawaan) -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-48 h-48 md:w-56 md:h-56 text-teal-600 dark:text-teal-400 drop-shadow-xl">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    <path d="M9 10a2 2 0 0 1 4 0c0 1-1 1.5-2 2"></path>
                    <circle cx="11" cy="15" r="1" fill="currentColor"></circle>
                </svg>
                
                <!-- Opsi 2: Jika Anda punya gambar logo sendiri (contoh ilustrasi PNG/SVG), hapus tag <svg> di atas dan gunakan baris di bawah ini: -->
                <!-- <img src="{{ asset('images/logo-404.png') }}" alt="404 Not Found" class="w-64 h-auto drop-shadow-xl"> -->
            </div>

            <!-- Teks 404 & Judul -->
            <h1 class="mt-4 text-3xl md:text-4xl font-bold text-gray-800 dark:text-white">404</h1>
            <h1 class="mt-4 text-3xl md:text-4xl font-bold text-gray-800 dark:text-white">HALAMAN TIDAK DITEMUKAN</h1>
            <p class="mt-4 text-lg md:text-xl text-gray-600 dark:text-gray-400">Halaman yang Anda cari mungkin telah dihapus, diganti namanya, atau tidak tersedia saat ini.</p>
            
            <!-- Tombol Beranda -->
                <div class="mt-10 flex justify-center">
            <a href="/"
                class="inline-flex items-center justify-center gap-2 md:gap-3 px-6 py-3 md:px-8 md:py-4 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 hover:-translate-y-1 hover:shadow-xl hover:shadow-teal-600/40 active:scale-95 focus:outline-none focus:ring-4 focus:ring-teal-600/30 transition-all duration-300 text-base md:text-lg w-full sm:w-auto whitespace-nowrap">
                <svg class="w-5 h-5 md:w-6 md:h-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
        </div>
    </div>
</body>
</html>