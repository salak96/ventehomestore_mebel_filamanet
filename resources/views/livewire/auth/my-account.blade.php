{{-- resources/views/livewire/auth/my-account.blade.php --}}
<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-start">
        <main class="w-full max-w-3xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Akun Saya</h1>

            {{-- Notifikasi global --}}
            @if (session('success'))
                <div class="mb-6 bg-green-500 text-white text-sm rounded-lg p-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-500 text-white text-sm rounded-lg p-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Kartu: Profil --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Profil</h2>

                    <form wire:submit.prevent="updateProfile" class="grid gap-y-4">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm mb-2 dark:text-white">Nama</label>
                            <div class="relative">
                                <input type="text" id="name" wire:model="name"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-gray-600"
                                    aria-describedby="name-error">
                                @error('name')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 16 16" fill="currentColor"
                                            aria-hidden="true">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('name')
                                <p class="text-xs text-gray-500 mt-2" id="name-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm mb-2 dark:text-white">Alamat Email</label>
                            <div class="relative">
                                <input type="email" id="email" wire:model="email"
                                    class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-gray-600"
                                    aria-describedby="email-error">
                                @error('email')
                                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 16 16" fill="currentColor"
                                            aria-hidden="true">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg>
                                    </div>
                                @enderror
                            </div>
                            @error('email')
                                <p class="text-xs text-gray-500 mt-2" id="email-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Spasi --}}
            <div class="h-6"></div>

            {{-- Kartu: Ganti Kata Sandi --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Ganti Kata Sandi</h2>

                    <form wire:submit.prevent="updatePassword" class="grid gap-y-4">
                        {{-- Password saat ini --}}
                        <div>
                            <label for="current_password" class="block text-sm mb-2 dark:text-white">Kata Sandi Saat Ini</label>
                            <div x-data="{ showCurrent: false }" class="relative">
                                <input :type="showCurrent ? 'text' : 'password'" id="current_password"
                                    wire:model="current_password"
                                    class="py-3 px-4 pr-10 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-gray-600"
                                    aria-describedby="current-password-error">
                                <button type="button" @click="showCurrent = !showCurrent"
                                    :aria-label="showCurrent ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                    class="absolute inset-y-0 end-0 pe-3 flex items-center">
                                    <svg x-show="!showCurrent" class="h-5 w-5 text-gray-500" ...></svg>
                                    <svg x-show="showCurrent" class="h-5 w-5 text-gray-500" ...></svg>
                                </button>
                                @error('current_password')
                                    <p class="text-xs text-gray-500 mt-2" id="current-password-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

            {{-- Password baru --}}
            <div>
                <label for="password" class="block text-sm mb-2 dark:text-white">Kata Sandi Baru</label>
                <div x-data="{ showNew: false }" class="relative">
                    <input :type="showNew ? 'text' : 'password'" id="password"
                        wire:model="password"
                        class="py-3 px-4 pr-10 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-gray-600"
                        aria-describedby="password-error">
                    <button type="button" @click="showNew = !showNew"
                        :aria-label="showNew ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                        class="absolute inset-y-0 end-0 pe-3 flex items-center">
                        <svg x-show="!showNew" class="h-5 w-5 text-gray-500" ...></svg>
                        <svg x-show="showNew" class="h-5 w-5 text-gray-500" ...></svg>
                    </button>
                    @error('password')
                        <p class="text-xs text-gray-500 mt-2" id="password-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
{{-- Konfirmasi password --}}
<div>
    <label for="password_confirmation" class="block text-sm mb-2 dark:text-white">Konfirmasi Kata Sandi Baru</label>
    <div x-data="{ showConfirm: false }" class="relative">
        <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation"
            wire:model="password_confirmation"
            class="py-3 px-4 pr-10 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-gray-600"
            aria-describedby="password-confirmation-error">
        <button type="button" @click="showConfirm = !showConfirm"
            :aria-label="showConfirm ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
            class="absolute inset-y-0 end-0 pe-3 flex items-center">
            <svg x-show="!showConfirm" class="h-5 w-5 text-gray-500" ...></svg>
            <svg x-show="showConfirm" class="h-5 w-5 text-gray-500" ...></svg>
        </button>
        @error('password_confirmation')
            <p class="text-xs text-gray-500 mt-2" id="password-confirmation-error">{{ $message }}</p>
        @enderror
    </div>
</div>
                        {{-- Tombol submit --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full sm:w-auto py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
