<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <img src="{{ asset('img/griya-batik.png') }}" alt="Batik Logo" class="h-16 w-auto">
                </div>
                
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Buat Akun Baru</h2>
                <p class="mt-1 text-md text-gray-600 dark:text-gray-400">Daftar untuk memulai perjalanan batik Anda</p>
            </div>

            <!-- Info Section -->
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded text-sm text-green-800">
                <strong>Selamat Datang!</strong><br>
                Buat akun Anda untuk mengakses workshop batik dan layanan eksklusif kami.
            </div>

            <!-- Register Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <form method="POST" action="{{ route('register.user') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-md font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <x-text-input id="name" name="name" type="text" required autofocus
                                class="block w-full pl-10 py-2 border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-md text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Masukkan nama lengkap Anda"
                                :value="old('name')" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-md font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <x-text-input id="email" name="email" type="email" required
                                class="block w-full pl-10 py-2 border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-md text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Masukkan email Anda"
                                :value="old('email')" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-md font-medium text-gray-700 dark:text-gray-300">Kata Sandi</label>
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2M6 20h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <x-text-input id="password" name="password" type="password" required
                                class="block w-full pl-10 py-2 border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-md text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Masukkan kata sandi" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-md font-medium text-gray-700 dark:text-gray-300">Konfirmasi Kata Sandi</label>
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </span>
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
                                class="block w-full pl-10 py-2 border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-md text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Konfirmasi kata sandi Anda" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start">
                        <input type="checkbox" name="terms" id="terms" required class="h-4 w-4 mt-1 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="terms" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            Saya setuju dengan <a href="#" class="text-indigo-600 hover:underline font-semibold">Syarat & Ketentuan</a> 
                            dan <a href="#" class="text-indigo-600 hover:underline font-semibold">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <!-- Button -->
                    <div>
                        <button type="submit"
                            class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-md shadow-md hover:shadow-lg transition transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Daftar Sekarang
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center pt-6">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Griya Batik. Semua Hak Dilindungi.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>