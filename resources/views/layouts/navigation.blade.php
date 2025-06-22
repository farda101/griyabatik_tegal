<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-500 to-indigo-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    {{-- PERBAIKAN DI SINI: Ganti x-application-logo dengan gambar logo kustom Anda --}}
                    @if (Auth::check()) {{-- Pastikan user login --}}
                        @if (Auth::user()->isSuperadmin)
                            <a href="{{ route('admin.dashboard') }}">
                                <img src="{{ asset('img/griya-batik.png') }}" alt="Admin Logo" class="block h-9 w-auto">
                            </a>
                        @elseif (Auth::user()->isKasir)
                            <a href="{{ route('kasir.dashboard') }}">
                                <img src="{{ asset('img/griya-batik.png') }}" alt="Kasir Logo" class="block h-9 w-auto">
                            </a>
                        @else
                            {{-- Jika ada role lain atau default user biasa --}}
                            <a href="{{ route('dashboard') }}">
                                <img src="{{ asset('img/griya-batik.png') }}" alt="Dashboard Logo" class="block h-9 w-auto">
                            </a>
                        @endif
                    @else
                        {{-- Jika user belum login, arahkan ke home publik --}}
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('img/griya-batik.png') }}" alt="Home Logo" class="block h-9 w-auto">
                        </a>
                    @endif
                    {{-- AKHIR PERBAIKAN --}}
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- Link Dashboard Dinamis --}}
                    @if (Auth::user()->isSuperadmin)
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:text-blue-100 focus:text-blue-100">
                            {{ __('Dashboard Admin') }}
                        </x-nav-link>
                    @elseif (Auth::user()->isKasir)
                        <x-nav-link :href="route('kasir.dashboard')" :active="request()->routeIs('kasir.dashboard')" class="text-white hover:text-blue-100 focus:text-blue-100">
                            {{ __('Dashboard Kasir') }}
                        </x-nav-link>
                    @else
                        {{-- Jika ada role lain atau default user biasa --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-blue-100 focus:text-blue-100">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endif

                    {{-- --- Navigasi Khusus Superadmin --- --}}
                    @if (Auth::user()->isSuperadmin)
                        {{-- Dropdown Manajemen Data Master --}}
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-blue-100 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ __('Master Data') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('admin.pengrajin.index')">
                                        {{ __('Manajemen Pengrajin') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.stock_batik.index')">
                                        {{ __('Manajemen Stok Batik') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.stock_bahan.index')">
                                        {{ __('Manajemen Stok Bahan') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.penggunaan_bahan.index')">
                                        {{ __('Manajemen Penggunaan Bahan') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        {{-- Dropdown Manajemen Workshop & Reservasi --}}
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-blue-100 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ __('Workshop & Reservasi') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('admin.paket_workshop.index')">
                                        {{ __('Manajemen Paket Workshop') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.jadwal_workshop.index')">
                                        {{ __('Manajemen Jadwal Workshop') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.reservasi.index')">
                                        {{ __('Manajemen Reservasi') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        {{-- Dropdown Content Management --}}
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-blue-100 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ __('Konten Edukasi') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('admin.galeri.index')">
                                        {{ __('Manajemen Galeri') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.video.index')">
                                        {{ __('Manajemen Video') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('admin.artikel.index')">
                                        {{ __('Manajemen Artikel') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif {{-- End Superadmin Only --}}

                    {{-- --- Navigasi untuk Kasir dan Superadmin --- --}}
                    @if (Auth::user()->isKasir || Auth::user()->isSuperadmin)
                        <x-nav-link :href="route('kasir.pos')" :active="request()->routeIs('kasir.pos')" class="text-white hover:text-blue-100 focus:text-blue-100">
                            {{ __('POS Kasir') }}
                        </x-nav-link>

                        {{-- Dropdown Laporan Kasir --}}
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-blue-100 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ __('Laporan Kasir') }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('kasir.laporan.penjualan.index')">
                                        {{ __('Laporan Penjualan Saya') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('kasir.laporan.stok.index')">
                                        {{ __('Laporan Stok') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('kasir.laporan.reservasi.index')">
                                        {{ __('Laporan Reservasi') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif {{-- End Kasir/Superadmin Only --}}

                </div>
            </div>

            {{-- Dropdown Profile (Hidden for now as requested) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-blue-100 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link> --}}

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-100 hover:text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            {{-- Link Dashboard Responsif Dinamis --}}
            @if (Auth::user()->isSuperadmin)
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Dashboard Admin') }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->isKasir)
                <x-responsive-nav-link :href="route('kasir.dashboard')" :active="request()->routeIs('kasir.dashboard')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Dashboard Kasir') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

            {{-- --- Responsive Navigasi Khusus Superadmin --- --}}
            @if (Auth::user()->isSuperadmin)
                <h3 class="px-3 pt-3 text-xs font-semibold text-blue-100 uppercase tracking-widest">{{ __('Master Data') }}</h3>
                <x-responsive-nav-link :href="route('admin.pengrajin.index')" :active="request()->routeIs('admin.pengrajin.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Pengrajin') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.stock_batik.index')" :active="request()->routeIs('admin.stock_batik.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Stok Batik') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.stock_bahan.index')" :active="request()->routeIs('admin.stock_bahan.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Stok Bahan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.penggunaan_bahan.index')" :active="request()->routeIs('admin.penggunaan_bahan.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Penggunaan Bahan') }}
                </x-responsive-nav-link>

                <h3 class="px-3 pt-3 text-xs font-semibold text-blue-100 uppercase tracking-widest">{{ __('Workshop & Reservasi') }}</h3>
                <x-responsive-nav-link :href="route('admin.paket_workshop.index')" :active="request()->routeIs('admin.paket_workshop.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Paket Workshop') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.jadwal_workshop.index')" :active="request()->routeIs('admin.jadwal_workshop.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Jadwal Workshop') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reservasi.index')" :active="request()->routeIs('admin.reservasi.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Reservasi') }}
                </x-responsive-nav-link>

                <h3 class="px-3 pt-3 text-xs font-semibold text-blue-100 uppercase tracking-widest">{{ __('Konten Edukasi') }}</h3>
                <x-responsive-nav-link :href="route('admin.galeri.index')" :active="request()->routeIs('admin.galeri.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Galeri') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.video.index')" :active="request()->routeIs('admin.video.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Video') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.artikel.index')" :active="request()->routeIs('admin.artikel.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Manajemen Artikel') }}
                </x-responsive-nav-link>
            @endif {{-- End Responsive Superadmin Only --}}

            {{-- --- Responsive Navigasi untuk Kasir dan Superadmin --- --}}
            @if (Auth::user()->isKasir || Auth::user()->isSuperadmin)
                <h3 class="px-3 pt-3 text-xs font-semibold text-blue-100 uppercase tracking-widest">{{ __('POS') }}</h3>
                <x-responsive-nav-link :href="route('kasir.pos')" :active="request()->routeIs('kasir.pos')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('POS Kasir') }}
                </x-responsive-nav-link>

                {{-- Dropdown Laporan Kasir --}}
                <h3 class="px-3 pt-3 text-xs font-semibold text-blue-100 uppercase tracking-widest">{{ __('Laporan') }}</h3>
                <x-responsive-nav-link :href="route('kasir.laporan.penjualan.index')" :active="request()->routeIs('kasir.laporan.penjualan.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Laporan Penjualan Saya') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasir.laporan.stok.index')" :active="request()->routeIs('kasir.laporan.stok.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Laporan Stok') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('kasir.laporan.reservasi.index')" :active="request()->routeIs('kasir.laporan.reservasi.*')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Laporan Reservasi') }}
                </x-responsive-nav-link>
            @endif {{-- End Responsive Kasir/Superadmin Only --}}
        </div>

        <div class="pt-4 pb-1 border-t border-blue-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-100">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                {{-- <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-blue-700 hover:text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link> --}}

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            class="text-white hover:bg-blue-700 hover:text-white">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>