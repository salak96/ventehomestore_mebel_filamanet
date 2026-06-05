<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="w-full max-w-md mx-auto p-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Masuk</h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Belum punya akun?
                            <a wire:navigate
                                class="text-teal-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                href="/register">
                                Daftar di sini
                            </a>
                        </p>
                    </div>

                    <hr class="my-5 border-slate-300">

                    <!-- Form -->
                    <form wire:submit.prevent='save'>
                        @if (session('error'))
                            <div class="mt-2 bg-red-500 text-sm text-white rounded-lg p-4 mb-4" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="grid gap-y-4">
                            <!-- Form Group -->
                            <div>
                                <label for="email" class="block text-sm mb-2 dark:text-white">Alamat Email</label>
                                <div class="relative">
                                    <input type="email" id="email" wire:model="email"
                                        class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                        aria-describedby="email-error">
                                    @error('email')
                                        <div class=" absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('email')
                                    <p class=" text-xs text-gray-500 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group: Kata Sandi dengan toggle mata -->
                            <div>
                                <div class="flex justify-between items-center">
                                    <label for="password" class="block text-sm mb-2 dark:text-white">Kata Sandi</label>
                                    <a wire:navigate href="/forgot"
                                        class="text-sm text-teal-600 hover:underline font-medium">Lupa Password?</a>
                                </div>

                                <!-- Alpine.js untuk toggle -->
                                <div x-data="{ show: false }" class="relative">
                                    <input :type="show ? 'text' : 'password'" id="password" wire:model="password"
                                        class="py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
                                        aria-describedby="password-error">

                                    <!-- Tombol ikon mata -->
                                    <button type="button" @click="show = !show"
                                        :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                        :title="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                        class="absolute inset-y-0 end-0 pe-3 flex items-center">
                                        <!-- eye -->
                                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path
                                                d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <!-- eye-off -->
                                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path d="M3 3l18 18" />
                                            <path d="M10.6 10.6A3 3 0 0 0 12 15a3 3 0 0 0 3-3" />
                                            <path
                                                d="M6.2 6.2C4.2 7.4 2.7 9.1 2.25 12c0 0 3.75 6.75 9.75 6.75 2.08 0 3.89-.57 5.39-1.47" />
                                            <path
                                                d="M13.5 6.35c.47-.08.93-.1 1.5-.1 6 0 9.75 6.75 9.75 6.75-.33 1.18-1.04 2.38-2.03 3.48" />
                                        </svg>
                                    </button>

                                    @error('password')
                                        <!-- Pindahkan ikon error sedikit ke kiri agar tidak menabrak tombol mata -->
                                        <div class="absolute inset-y-0 end-10 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                <path
                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                            </svg>
                                        </div>
                                    @enderror
                                </div>

                                @error('password')
                                    <p class="text-xs text-gray-500 mt-2" id="password-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Form Group -->
                            <button type="submit"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Masuk</button>
                        </div>
                    </form>
                    <!-- End Form -->

                    <div class="mt-5">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="bg-white px-2 text-gray-500">atau</span>
                            </div>
                        </div>

                        <div class="mt-5">
                            <a href="{{ route('social.redirect', 'google') }}"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-3 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 shadow-sm">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                </svg>
                                Masuk dengan Google
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
