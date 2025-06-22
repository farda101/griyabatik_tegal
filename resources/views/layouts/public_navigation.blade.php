<nav x-data="{ open: false }" 
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-gray-800 bg-gray-900">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center">
                {{-- Logo dan Nama Brand --}}
                <a href="{{ route('home') }}" class="group flex items-center space-x-3">
                    <div class="relative">
                        {{-- Ganti x-application-logo dengan gambar logo kustom Anda --}}
                        <img src="{{ asset('img/griya-batik.png') }}" alt="Batik Tegalan Logo" class="block h-12 w-auto">
                        {{-- Efek Blur Hover (disesuaikan agar cocok dengan logo baru jika perlu) --}}
                        {{-- <div class="absolute -inset-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-20 transition-opacity duration-300 blur"></div> --}}
                    </div>
                    {{-- Nama Brand (Hanya Tampil di Layar Selain HP) --}}
                    <div class="hidden sm:block">
                        <div class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Batik Tegalan
                        </div>
                        <div class="text-xs text-gray-400 -mt-1">Workshop & Edukasi</div>
                    </div>
                </a>
            </div>

            {{-- Navigasi Utama (Desktop) --}}
            <div class="hidden lg:flex items-center space-x-1">
                {{-- Link Home --}}
                <x-nav-link :href="route('home')" 
                            :active="request()->routeIs('home')" 
                            class="relative px-6 py-3 rounded-xl font-semibold text-gray-300 hover:text-white transition-all duration-300 group">
                    <span class="relative z-10">{{ __('Home') }}</span>
                    {{-- Efek Hover dan Aktif --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl opacity-0 group-hover:opacity-100 {{ request()->routeIs('home') ? 'opacity-100' : '' }} transition-opacity duration-300"></div>
                    @if(request()->routeIs('home'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                    @endif
                </x-nav-link>

                {{-- Link Reservasi Workshop --}}
                <x-nav-link :href="route('reservasi.create')" 
                            :active="request()->routeIs('reservasi.create')" 
                            class="relative px-6 py-3 rounded-xl font-semibold text-gray-300 hover:text-white transition-all duration-300 group">
                    <span class="relative z-10 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Reservasi Workshop') }}
                    </span>
                    {{-- Efek Hover dan Aktif --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl opacity-0 group-hover:opacity-100 {{ request()->routeIs('reservasi.create') ? 'opacity-100' : '' }} transition-opacity duration-300"></div>
                    @if(request()->routeIs('reservasi.create'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                    @endif
                </x-nav-link>

                {{-- Link Edukasi Batik --}}
                <x-nav-link :href="route('edu.home')" 
                            :active="request()->routeIs('edu.home')" 
                            class="relative px-6 py-3 rounded-xl font-semibold text-gray-300 hover:text-white transition-all duration-300 group">
                    <span class="relative z-10 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ __('Edukasi Batik') }}
                    </span>
                    {{-- Efek Hover dan Aktif --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl opacity-0 group-hover:opacity-100 {{ request()->routeIs('edu.home') ? 'opacity-100' : '' }} transition-opacity duration-300"></div>
                    @if(request()->routeIs('edu.home'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                    @endif
                </x-nav-link>

                {{-- Link Cek Reservasi --}}
                <x-nav-link :href="route('reservasi.status.check.form')" 
                            :active="request()->routeIs('reservasi.status.check.form')" 
                            class="relative px-6 py-3 rounded-xl font-semibold text-gray-300 hover:text-white transition-all duration-300 group">
                    <span class="relative z-10 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        {{ __('Cek Reservasi') }}
                    </span>
                    {{-- Efek Hover dan Aktif --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl opacity-0 group-hover:opacity-100 {{ request()->routeIs('reservasi.status.check.form') ? 'opacity-100' : '' }} transition-opacity duration-300"></div>
                    @if(request()->routeIs('reservasi.status.check.form'))
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                    @endif
                </x-nav-link>
            </div>

            {{-- Tombol Daftar Sekarang (Desktop) --}}
            <div class="hidden lg:flex items-center space-x-4">
                <a href="{{ route('reservasi.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Daftar Sekarang
                </a>
                
                {{-- Optional Login Button (Uncomment to enable) --}}
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-indigo-600 transition-colors duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Admin
                    </a>
                @endif
            </div>

            {{-- Tombol Toggle Menu Mobile --}}
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" 
                        class="relative inline-flex items-center justify-center p-3 rounded-xl text-gray-300 hover:text-indigo-400 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-300"
                        :class="{ 'bg-gray-800 text-indigo-400': open }">
                    <span class="sr-only">Open main menu</span>
                    <div class="relative w-6 h-6">
                        <span :class="{ 'rotate-45 translate-y-1.5': open, 'rotate-0 translate-y-0': !open }" 
                              class="absolute top-0 left-0 w-full h-0.5 bg-current transform transition-all duration-300 origin-center"></span>
                        <span :class="{ 'opacity-0 scale-0': open, 'opacity-100 scale-100': !open }" 
                              class="absolute top-1/2 left-0 w-full h-0.5 bg-current transform -translate-y-1/2 transition-all duration-300"></span>
                        <span :class="{ '-rotate-45 -translate-y-1.5': open, 'rotate-0 translate-y-0': !open }" 
                              class="absolute bottom-0 left-0 w-full h-0.5 bg-current transform transition-all duration-300 origin-center"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Responsive (Mobile) --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="lg:hidden bg-gray-900 backdrop-blur-md border-t border-gray-200/50">
        
        <div class="px-4 py-6 space-y-2">
            {{-- Link Home (Mobile) --}}
            <x-responsive-nav-link :href="route('home')" 
                                   :active="request()->routeIs('home')"
                                   class="flex items-center px-4 py-3 rounded-xl font-semibold text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600 transition-all duration-300"
                                   :class="request()->routeIs('home') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-l-4 border-indigo-400' : ''">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-700 to-purple-700 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                {{ __('Home') }}
            </x-responsive-nav-link>

            {{-- Link Reservasi Workshop (Mobile) --}}
            <x-responsive-nav-link :href="route('reservasi.create')" 
                                   :active="request()->routeIs('reservasi.create')"
                                   class="flex items-center px-4 py-3 rounded-xl font-semibold text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600 transition-all duration-300"
                                   :class="request()->routeIs('reservasi.create') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-l-4 border-indigo-400' : ''">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-700 to-purple-700 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                {{ __('Reservasi Workshop') }}
            </x-responsive-nav-link>

            {{-- Link Edukasi Batik (Mobile) --}}
            <x-responsive-nav-link :href="route('edu.home')" 
                                   :active="request()->routeIs('edu.home')"
                                   class="flex items-center px-4 py-3 rounded-xl font-semibold text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600 transition-all duration-300"
                                   :class="request()->routeIs('edu.home') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-l-4 border-indigo-400' : ''">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-700 to-purple-700 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                {{ __('Edukasi Batik') }}
            </x-responsive-nav-link>

            {{-- Link Cek Reservasi (Mobile) --}}
            <x-responsive-nav-link :href="route('reservasi.status.check.form')" 
                                   :active="request()->routeIs('reservasi.status.check.form')"
                                   class="flex items-center px-4 py-3 rounded-xl font-semibold text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600 transition-all duration-300"
                                   :class="request()->routeIs('reservasi.status.check.form') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white border-l-4 border-indigo-400' : ''">
                <div class="w-8 h-8 bg-gradient-to-r from-indigo-700 to-purple-700 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                {{ __('Cek Reservasi') }}
            </x-responsive-nav-link>

            <div class="pt-4 mt-4 border-t border-gray-800">
                <a href="{{ route('reservasi.create') }}" 
                   class="flex items-center justify-center w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Daftar Workshop Sekarang
                </a>
            </div>

            {{-- Optional Mobile Login --}}
            @if (Route::has('login'))
                <div class="pt-2">
                    <x-responsive-nav-link :href="route('login')"
                                           class="flex items-center px-4 py-3 rounded-xl font-medium text-gray-300 hover:text-indigo-400 hover:bg-gray-800 transition-all duration-300">
                        <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        {{ __('Login Admin') }}
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>
    </div>
</nav>

{{-- Add padding to body to compensate for fixed navbar --}}
<div class="h-20"></div>