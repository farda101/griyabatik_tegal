@extends('layouts.public') {{-- Menggunakan layout publik --}}

@section('title', 'Koleksi Video Edukasi Batik')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-8 text-white text-center">
                <h1 class="font-bold text-3xl mb-2">
                    Koleksi Video Edukasi Batik
                </h1>
                <p class="text-purple-100 text-lg">Tonton dan pelajari berbagai teknik dan filosofi batik melalui video interaktif kami.</p>
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
                        Pilih video yang ingin Anda tonton untuk memperdalam pengetahuan dan keterampilan membatik Anda.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($videos as $video)
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
                                <h3 class="font-bold text-xl text-gray-900 mb-2 leading-tight line-clamp-2 group-hover:text-purple-600 transition duration-300">{{ $video->judul }}</h3>
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Durasi: {{ $video->durasi_format }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Tayangan: {{ number_format($video->views_count) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-5-4v6m4-2H6a2 2 0 01-2-2V8a2 2 0 012-2h8a2 2 0 012 2v2"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Video</h3>
                            <p class="text-gray-600">Saat ini belum ada video edukasi yang tersedia.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($videos->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $videos->links('vendor.pagination.tailwind') }} {{-- Pastikan Anda punya pagination view ini atau gunakan defaultnya --}}
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
</style>
@endsection