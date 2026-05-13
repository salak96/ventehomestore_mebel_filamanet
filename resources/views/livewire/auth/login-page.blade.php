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
                </div>
            </div>
        </main>
    </div>
</div>
