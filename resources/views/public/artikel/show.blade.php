@extends('layouts.public') {{-- Menggunakan layout publik --}}

@section('title', $artikel->judul . ' - Artikel Batik')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-8 text-white text-center">
                <h1 class="font-bold text-3xl sm:text-4xl leading-tight mb-2">
                    {{ $artikel->judul }}
                </h1>
                <p class="text-indigo-100 text-lg">Jelajahi setiap detail keindahan batik.</p>
            </div>

            <div class="p-8">
                {{-- Informasi Penulis dan Metadata --}}
                <div class="text-center text-gray-600 mb-8 flex flex-wrap justify-center items-center gap-y-2 gap-x-6">
                    <span class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Oleh <span class="font-semibold ml-1">{{ $artikel->author->name ?? 'Anonim' }}</span>
                    </span>
                    <span class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($artikel->published_at)->format('d F Y') }}
                    </span>
                    <span class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $artikel->reading_time }}
                    </span>
                    <span class="flex items-center text-sm">
                        <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($artikel->views_count) }} Tayangan
                    </span>
                </div>

                {{-- Gambar Unggulan --}}
                @if($artikel->featured_image)
                    <div class="mb-8 overflow-hidden rounded-xl shadow-lg border border-gray-200">
                        <img src="{{ asset('storage/' . $artikel->featured_image) }}" alt="{{ $artikel->judul }}" class="w-full h-auto object-cover max-h-96">
                    </div>
                @else
                    <div class="mb-8 w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500 rounded-xl shadow-md border border-gray-200">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                {{-- Konten Artikel --}}
                <div class="prose max-w-none text-gray-800 leading-relaxed text-lg mb-10 prose-indigo prose-a:text-indigo-600 prose-img:rounded-lg prose-img:shadow-md">
                    {!! $artikel->konten !!} {{-- Render HTML dari editor (pastikan aman dari XSS!) --}}
                </div>

                {{-- Tombol Navigasi --}}
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('edu.artikel.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-700 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-gray-600 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Kembali ke Semua Artikel
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