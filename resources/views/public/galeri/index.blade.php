@extends('layouts.public') {{-- Menggunakan layout publik --}}

@section('title', 'Koleksi Galeri Batik')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 p-8 text-white text-center">
                <h1 class="font-bold text-3xl mb-2">
                    Galeri Keindahan Batik
                </h1>
                <p class="text-green-100 text-lg">Jelajahi ragam motif dan pesona visual batik Tegalan.</p>
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
                        Saksikan koleksi foto-foto terbaik kami yang menampilkan keindahan proses, motif, dan hasil karya batik.
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse ($galeris as $foto)
                        <a href="{{ route('edu.galeri.show', $foto->id) }}" class="group relative block bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-xl border border-gray-100 aspect-video sm:aspect-square">
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
                                <h3 class="font-bold text-white text-base leading-tight line-clamp-2">{{ $foto->judul }}</h3>
                            </div>
                            <div class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 shadow">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Foto</h3>
                            <p class="text-gray-600">Saat ini belum ada foto yang tersedia di galeri.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($galeris->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $galeris->links('vendor.pagination.tailwind') }} {{-- Pastikan Anda punya pagination view ini atau gunakan defaultnya --}}
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

{{-- Custom Styles for Line Clamp and Aspect Ratio --}}
<style>
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

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