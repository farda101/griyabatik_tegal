@extends('layouts.public') {{-- Menggunakan layout publik --}}

@section('title', $galeri->judul . ' - Galeri Batik')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 p-8 text-white text-center">
                <h1 class="font-bold text-3xl sm:text-4xl leading-tight mb-2">
                    {{ $galeri->judul }}
                </h1>
                <p class="text-green-100 text-lg">Detail lengkap keindahan karya batik ini.</p>
            </div>

            <div class="p-8">
                {{-- Tampilan Foto Utama --}}
                <div class="mb-8 overflow-hidden rounded-xl shadow-lg border border-gray-200">
                    @if($galeri->foto)
                        <img src="{{ asset('storage/' . $galeri->foto) }}" alt="{{ $galeri->judul }}" class="w-full h-auto object-cover max-h-[500px]">
                    @else
                        <div class="bg-gray-100 flex flex-col items-center justify-center h-64 sm:h-96 rounded-xl border border-gray-200 text-gray-500">
                            <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p>Foto tidak tersedia</p>
                        </div>
                    @endif
                </div>

                {{-- Detail Informasi Foto --}}
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="font-semibold text-xl text-gray-800 mb-5 flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Informasi Foto
                    </h3>
                    <dl class="divide-y divide-gray-200 bg-gray-50 rounded-lg p-5">
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Judul Foto
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">
                                {{ $galeri->judul }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Deskripsi Foto
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $galeri->deskripsi ?? 'Tidak ada deskripsi yang tersedia.' }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Status Tampilan
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                @php
                                    $statusText = $galeri->is_active ? 'Aktif (Ditampilkan)' : 'Non-Aktif (Tidak Ditampilkan)';
                                    $statusClass = $galeri->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                @endphp
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Upload
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">{{ \Carbon\Carbon::parse($galeri->created_at)->format('d F Y H:i') }} WIB</dd>
                        </div>
                    </dl>
                </div>

                {{-- Tombol Navigasi --}}
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('edu.galeri.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-700 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-gray-600 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Kembali ke Semua Foto
                    </a>
                    <a href="{{ route('edu.home') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Halaman Edukasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection