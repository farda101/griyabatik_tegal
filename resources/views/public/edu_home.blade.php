@extends('layouts.public')

@section('title', 'Edukasi Batik')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-teal-600 to-blue-600 p-8 text-white text-center">
                <h2 class="font-bold text-3xl mb-2">
                    Edukasi Batik
                </h2>
                <p class="text-teal-100 text-lg">Belajar dan Jelajahi Keindahan Warisan Batik Indonesia</p>
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

                <p class="text-center text-lg text-gray-700 mb-10 max-w-2xl mx-auto">
                    Temukan kekayaan budaya batik melalui berbagai sumber edukasi kami, mulai dari artikel mendalam, video tutorial, hingga galeri foto inspiratif.
                </p>

                {{-- Bagian Artikel Terbaru --}}
                <section class="mb-12 border-t border-gray-200 pt-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                        <h3 class="font-semibold text-2xl text-gray-800 flex items-center mb-4 sm:mb-0">
                            <svg class="w-7 h-7 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H9m4 0h-2m-2 4h4m-4 4h4m-4 4h4"/>
                            </svg>
                            Artikel Terbaru
                        </h3>
                        <a href="{{ route('edu.artikel.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 border border-indigo-200 rounded-lg text-indigo-700 hover:bg-indigo-100 transition duration-150 ease-in-out text-sm font-medium">
                            Lihat Semua Artikel
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @forelse ($latestArticles as $artikel)
                            <div class="group bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100">
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
                                    <h4 class="font-bold text-lg text-gray-900 mb-2 leading-tight line-clamp-2 group-hover:text-indigo-600 transition duration-300">{{ $artikel->judul }}</h4>
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $artikel->excerpt }}</p>
                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span>Oleh: {{ $artikel->author->name ?? 'Anonim' }}</span>
                                        <a href="{{ route('edu.artikel.show', $artikel->slug) }}" class="text-indigo-600 hover:text-indigo-900 font-medium flex items-center">
                                            Baca Selengkapnya
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="md:col-span-3 text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600">Belum ada artikel terbaru saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Bagian Video Terbaru --}}
                <section class="mb-12 border-t border-gray-200 pt-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                        <h3 class="font-semibold text-2xl text-gray-800 flex items-center mb-4 sm:mb-0">
                            <svg class="w-7 h-7 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-5-4v6m4-2H6a2 2 0 01-2-2V8a2 2 0 012-2h8a2 2 0 012 2v2"/>
                            </svg>
                            Video Edukasi Terbaru
                        </h3>
                        <a href="{{ route('edu.video.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-50 border border-purple-200 rounded-lg text-purple-700 hover:bg-purple-100 transition duration-150 ease-in-out text-sm font-medium">
                            Lihat Semua Video
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @forelse ($latestVideos as $video)
                            <div class="group bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100">
                                <a href="{{ route('edu.video.show', $video->id) }}" class="block relative">
                                    @if($video->thumbnail)
                                        <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->judul }}" class="w-full h-48 object-cover transition-all duration-300 group-hover:opacity-80">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-5-4v6m4-2H6a2 2 0 01-2-2V8a2 2 0 012-2h8a2 2 0 012 2v2"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </a>
                                <div class="p-5">
                                    <h4 class="font-bold text-lg text-gray-900 mb-2 leading-tight line-clamp-2 group-hover:text-purple-600 transition duration-300">{{ $video->judul }}</h4>
                                    <div class="flex justify-between items-center text-xs text-gray-500">
                                        <span>Durasi: {{ $video->durasi_format }}</span>
                                        <a href="{{ route('edu.video.show', $video->id) }}" class="text-purple-600 hover:text-purple-900 font-medium flex items-center">
                                            Tonton Video
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="md:col-span-3 text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-5-4v6m4-2H6a2 2 0 01-2-2V8a2 2 0 012-2h8a2 2 0 012 2v2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600">Belum ada video edukasi terbaru saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Bagian Galeri Foto Terbaru --}}
                <section class="border-t border-gray-200 pt-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                        <h3 class="font-semibold text-2xl text-gray-800 flex items-center mb-4 sm:mb-0">
                            <svg class="w-7 h-7 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Galeri Foto Terbaru
                        </h3>
                        <a href="{{ route('edu.galeri.index') }}" class="inline-flex items-center px-4 py-2 bg-green-50 border border-green-200 rounded-lg text-green-700 hover:bg-green-100 transition duration-150 ease-in-out text-sm font-medium">
                            Lihat Semua Foto
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse ($latestGalleries as $foto)
                            <div class="group relative bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100 aspect-video sm:aspect-square">
                                <a href="{{ route('edu.galeri.show', $foto->id) }}" class="block h-full w-full">
                                    @if($foto->foto)
                                        <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $foto->judul }}" class="w-full h-full object-cover transition-all duration-300 group-hover:opacity-80">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                        <h4 class="font-bold text-white text-base leading-tight line-clamp-2">{{ $foto->judul }}</h4>
                                    </div>
                                    <div class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 shadow">
                                        <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="md:col-span-4 text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600">Belum ada foto di galeri terbaru saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles for Line Clamp and Aspect Ratio --}}
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

/* Default aspect ratio for gallery items */
.aspect-video {
    aspect-ratio: 16 / 9;
}

@media (min-width: 640px) { /* Small screens and up, make gallery items square */
    .sm\:aspect-square {
        aspect-ratio: 1 / 1;
    }
}
</style>
@endsection