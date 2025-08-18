<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <img src="{{ asset('img/griya-batik.png') }}" alt="Batik Logo" class="h-16 w-auto">
                </div>
                
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Masuk Akun Anda</h2>
                <p class="mt-1 text-md text-gray-600 dark:text-gray-400">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Catatan Pengguna -->
            <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded text-sm text-blue-800">
                <strong>Catatan:</strong><br>
                Jika Anda belum memiliki akun, silakan lakukan <a href="{{ route('register.user.form') }}" class="text-indigo-600 underline font-semibold">registrasi akun</a> terlebih dahulu. Akun Anda akan dibuat otomatis.
            </div>

            <!-- Login Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
                <x-auth-session-status class="mb-4 p-3 bg-green-50 border border-green-300 text-green-700 rounded" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-md font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <div class="mt-1 relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <x-text-input id="email" name="email" type="email" required autofocus
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
                                    <path d="M12 15v2M6 20h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <x-text-input id="password" name="password" type="password" required
                                class="block w-full pl-10 py-2 border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-md text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Masukkan kata sandi" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <span class="ml-2 text-md text-gray-600 dark:text-gray-400">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-md text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Button -->
                    <div>
                        <button type="submit"
                            class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-md shadow-md hover:shadow-lg transition transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center pt-6">
                <p class="text-xs text-gray-500  dark:text-gray-400">
                    &copy; {{ date('Y') }} Griya Batik. Semua Hak Dilindungi.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
