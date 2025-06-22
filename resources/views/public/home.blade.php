@extends('layouts.public')

@section('title', 'Selamat Datang di Workshop Batik Tegalan')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen">
    {{-- Hero Section dengan Gradient Background --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/80 to-purple-900/80"></div>
        </div>

        <div class="relative pt-16 pb-32 sm:pt-24 sm:pb-40 lg:pt-32 lg:pb-48">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    {{-- Content Section --}}
                    <div class="text-center lg:text-left">
                        <div class="mb-6">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Workshop Batik Terpercaya
                            </span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                            Jelajahi
                            <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                                Keindahan
                            </span>
                            Batik Tegalan
                        </h1>

                        <p class="mt-6 text-xl text-gray-200 max-w-2xl mx-auto lg:mx-0">
                            Bergabunglah dengan workshop membatik kami, pelajari sejarah dan filosofi batik, serta miliki karya batik asli langsung dari tangan pengrajin terbaik Tegalan.
                        </p>

                        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('reservasi.create') }}"
                               class="inline-flex items-center px-8 py-4 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold text-lg hover:from-yellow-600 hover:to-orange-600 transform hover:scale-105 transition duration-300 shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Daftar Workshop Sekarang
                            </a>
                            <a href="#workshop-section"
                               class="inline-flex items-center px-8 py-4 rounded-xl border-2 border-white text-white font-semibold text-lg hover:bg-white hover:text-indigo-900 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pelajari Lebih Lanjut
                            </a>
                        </div>

                        {{-- Stats Section --}}
                        <div class="mt-12 grid grid-cols-3 gap-6 text-center">
                            <div>
                                <div class="text-3xl font-bold text-yellow-400">500+</div>
                                <div class="text-sm text-gray-300">Peserta Puas</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-yellow-400">50+</div>
                                <div class="text-sm text-gray-300">Workshop Selesai</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-yellow-400">10+</div>
                                <div class="text-sm text-gray-300">Tahun Pengalaman</div>
                            </div>
                        </div>
                    </div>

                    {{-- Images Gallery --}}
                    <div class="hidden lg:block">
                        <div class="relative">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-4">
                                    <div class="relative group">
                                        <img src="{{ asset('img/hero-batik-1.jpg') }}"
                                             alt="Batik pattern 1"
                                             class="w-full h-48 object-cover rounded-2xl shadow-2xl transform group-hover:scale-105 transition duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                    </div>
                                    <div class="relative group">
                                        <img src="{{ asset('img/hero-batik-2.jpg') }}"
                                             alt="Batik pattern 2"
                                             class="w-full h-32 object-cover rounded-2xl shadow-2xl transform group-hover:scale-105 transition duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                    </div>
                                </div>
                                <div class="space-y-4 pt-8">
                                    <div class="relative group">
                                        <img src="{{ asset('img/hero-batik-3.jpg') }}"
                                             alt="Batik pattern 3"
                                             class="w-full h-32 object-cover rounded-2xl shadow-2xl transform group-hover:scale-105 transition duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                    </div>
                                    <div class="relative group">
                                        <img src="{{ asset('img/hero-batik-4.jpg') }}"
                                             alt="Batik pattern 4"
                                             class="w-full h-48 object-cover rounded-2xl shadow-2xl transform group-hover:scale-105 transition duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Wave Separator --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="url(#paint0_linear)"/>
                <defs>
                    <linearGradient id="paint0_linear" x1="0" y1="0" x2="0" y2="1" gradientUnits="objectBoundingBox">
                        <stop stop-color="#F9FAFB"/>
                        <stop offset="1" stop-color="#F3F4F6"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div>

    {{-- Workshop Mendatang Section --}}
    <div id="workshop-section" class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Workshop Mendatang</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Temukan jadwal workshop yang sesuai dengan waktu Anda dan bergabunglah dengan komunitas pecinta batik
            </p>
            <div class="mt-6 w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:gap-10">
            @forelse ($upcomingWorkshops as $jadwal)
                <div class="group relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                    <div class="p-8">
                        {{-- Status Badge --}}
                        <div class="flex justify-between items-start mb-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                Tersedia
                            </span>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-indigo-600">
                                    {{ $jadwal->slot_tersisa }}
                                </div>
                                <div class="text-xs text-gray-500">slot tersisa</div>
                            </div>
                        </div>

                        {{-- Workshop Title --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-4 group-hover:text-indigo-600 transition duration-300">
                            {{ $jadwal->paketWorkshop->nama_paket ?? 'Paket Tidak Ditemukan' }}
                        </h3>

                        {{-- Workshop Details --}}
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('l') }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Durasi: {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->diffInHours(\Carbon\Carbon::parse($jadwal->jam_selesai)) }} jam
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center text-gray-600">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-2xl text-gray-900">
                                        Rp {{ number_format($jadwal->paketWorkshop->harga_individu ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500">per orang</div>
                                </div>
                            </div>
                        </div>

                        {{-- CTA Button --}}
                        <a href="{{ route('reservasi.create') }}"
                           class="block w-full text-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-300 shadow-lg group-hover:shadow-xl">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Workshop</h3>
                    <p class="text-gray-600 mb-6">Tidak ada jadwal workshop mendatang yang tersedia saat ini.</p>
                    <a href="{{ route('reservasi.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-300">
                        Hubungi Kami untuk Jadwal Khusus
                    </a>
                </div>
            @endforelse
        </div>

        @if($upcomingWorkshops->isNotEmpty())
        <div class="mt-16 text-center">
            <a href="{{ route('reservasi.create') }}"
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold text-lg rounded-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-300 shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Lihat Semua Jadwal & Daftar Sekarang
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        @endif
    </div>

    {{-- Educational Content Section --}}
    <div class="bg-gradient-to-br from-gray-50 to-indigo-50">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Pelajari Batik Lebih Dalam</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Jelajahi warisan budaya Indonesia melalui artikel, video edukasi, dan galeri foto yang menakjubkan
                </p>
                <div class="mt-6 w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Artikel Section --}}
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Artikel Pilihan</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-6">
                            @forelse ($latestArticles as $artikel)
                                <article class="group">
                                    <a href="{{ route('edu.artikel.show', $artikel->slug) }}"
                                       class="block space-y-3 hover:bg-gray-50 p-4 rounded-xl transition duration-300">
                                        <h4 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition duration-300 line-clamp-2">
                                            {{ $artikel->judul }}
                                        </h4>
                                        <p class="text-gray-600 text-sm line-clamp-3">{{ $artikel->excerpt }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs text-gray-500">{{ $artikel->author->name ?? 'Anonim' }}</span>
                                            <span class="text-xs text-indigo-600 font-medium group-hover:text-indigo-700">
                                                Baca Selengkapnya →
                                            </span>
                                        </div>
                                    </a>
                                </article>
                            @empty
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600">Belum ada artikel pilihan.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('edu.artikel.index') }}"
                               class="flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition duration-300">
                                Lihat Semua Artikel
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Video Section --}}
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Video Edukasi</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-6">
                            @forelse ($latestVideos as $video)
                                <article class="group">
                                    <a href="{{ route('edu.video.show', $video->id) }}"
                                       class="block space-y-3 hover:bg-gray-50 p-4 rounded-xl transition duration-300">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M8 5v14l11-7z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition duration-300 line-clamp-2">
                                                    {{ $video->judul }}
                                                </h4>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        {{ $video->durasi_format }}
                                                    </span>
                                                    <span class="text-xs text-purple-600 font-medium group-hover:text-purple-700">
                                                        Tonton →
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            @empty
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600">Belum ada video edukasi.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('edu.video.index') }}"
                               class="flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-700 transition duration-300">
                                Lihat Semua Video
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Gallery Section --}}
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1">
                    <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Galeri Foto</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        @forelse ($latestGalleries->take(4) as $foto)
                            @if($loop->first)
                            <div class="grid grid-cols-2 gap-3 mb-6">
                            @endif
                                <a href="{{ route('edu.galeri.show', $foto->id) }}"
                                   class="group relative overflow-hidden rounded-xl aspect-square hover:shadow-lg transition-all duration-300">
                                    <img src="{{ asset('storage/' . $foto->foto) }}"
                                         alt="{{ $foto->judul }}"
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-full group-hover:translate-y-0 transition duration-300">
                                        <p class="text-white text-sm font-medium truncate">{{ $foto->judul }}</p>
                                    </div>
                                    <div class="absolute top-2 right-2 w-8 h-8 bg-white bg-opacity-90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                </a>
                            @if($loop->last)
                            </div>
                            @endif
                        @empty
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600">Belum ada foto di galeri.</p>
                            </div>
                        @endforelse

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('edu.galeri.index') }}"
                               class="flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-teal-700 transition duration-300">
                                Lihat Semua Galeri
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA Section --}}
    <div class="bg-gradient-to-r from-indigo-900 via-purple-900 to-pink-900 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <svg class="absolute bottom-0 left-0 w-full h-20 text-white opacity-10" viewBox="0 0 1440 120" fill="currentColor">
                <path d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,58.7C672,53,768,43,864,48C960,53,1056,75,1152,85.3C1248,96,1344,96,1392,96L1440,96L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"/>
            </svg>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-4xl font-bold text-white mb-6">
                    Siap Memulai Perjalanan Batik Anda?
                </h2>
                <p class="text-xl text-gray-200 max-w-3xl mx-auto mb-10">
                    Bergabunglah dengan ribuan peserta lainnya yang telah merasakan pengalaman luar biasa belajar membatik bersama master pengrajin terbaik Tegalan.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('reservasi.create') }}"
                       class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold text-xl rounded-2xl hover:from-yellow-600 hover:to-orange-600 transform hover:scale-105 transition duration-300 shadow-2xl">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Daftar Workshop Sekarang
                    </a>

                    <div class="flex items-center space-x-6 text-white">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-sm">Rating 4.9/5</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">100% Puas</span>
                        </div>
                    </div>
                </div>

                {{-- Trust Indicators --}}
                <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 items-center opacity-60">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">500+</div>
                        <div class="text-sm text-gray-300">Peserta Bahagia</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">50+</div>
                        <div class="text-sm text-gray-300">Workshop Selesai</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">10+</div>
                        <div class="text-sm text-gray-300">Tahun Pengalaman</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-white">100%</div>
                        <div class="text-sm text-gray-300">Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles for Line Clamp --}}
<style>
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

.aspect-square {
    aspect-ratio: 1 / 1;
}

@media (max-width: 640px) {
    .aspect-square {
        aspect-ratio: 4 / 3;
    }
}
</style>

@endsection