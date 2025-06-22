@extends('layouts.public') {{-- Menggunakan layout publik --}}

@section('title', 'Daftar Artikel Batik')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-8 text-white text-center">
                <h1 class="font-bold text-3xl mb-2">
                    Koleksi Artikel Edukasi Batik
                </h1>
                <p class="text-indigo-100 text-lg">Jelajahi berbagai artikel menarik tentang sejarah, filosofi, dan teknik membatik.</p>
            </div>

            <div class="p-8">
                {{-- Notifikasi (jika ada) --}}
                @if (Session::has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ Session::get('success') }}</span>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ Session::get('error') }}</span>
                    </div>
                @endif

                <div class="text-center mb-8">
                    <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                        Di sini Anda bisa menemukan artikel mendalam yang akan memperkaya pemahaman Anda tentang warisan batik Indonesia.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($artikels as $artikel)
                        <a href="{{ route('edu.artikel.show', $artikel->slug) }}" class="group block bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100">
                            @if($artikel->featured_image)
                                <img src="{{ asset('storage/' . $artikel->featured_image) }}" alt="{{ $artikel->judul }}" class="w-full h-48 object-cover transition-all duration-300 group-hover:opacity-80">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5">
                                <h3 class="font-bold text-xl text-gray-900 mb-2 leading-tight line-clamp-2 group-hover:text-indigo-600 transition duration-300">{{ $artikel->judul }}</h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $artikel->excerpt }}</p>
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <span>Oleh: {{ $artikel->author->name ?? 'Anonim' }}</span>
                                    <span>{{ \Carbon\Carbon::parse($artikel->published_at)->format('d F Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs text-gray-500 mt-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $artikel->reading_time }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        {{ number_format($artikel->views_count) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-16">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Artikel</h3>
                                <p class="text-gray-600">Saat ini belum ada artikel edukasi yang dipublikasikan.</p>
                            </div>
                        @endforelse
                </div>

                {{-- Pagination --}}
                @if ($artikels->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $artikels->links('vendor.pagination.tailwind') }} {{-- Pastikan Anda punya pagination view ini atau gunakan defaultnya --}}
                    </div>
                @endif

                <div class="mt-12 text-center pt-6 border-t border-gray-200">
                    <a href="{{ route('edu.home') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-700 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-gray-600 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Kembali ke Halaman Edukasi
                    </a>
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
</style>
@endsection