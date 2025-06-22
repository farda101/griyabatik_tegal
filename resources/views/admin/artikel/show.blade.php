@extends('layouts.app')

@section('title', 'Detail Artikel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Tetap 7xl untuk konten artikel --}}

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Detail/Mata untuk Artikel --}}
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Artikel</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Untuk artikel: <span class="font-semibold text-blue-700">{{ $artikel->judul }}</span></p>
            </div>
        </div>

        {{-- Main Content Card with Details --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            {{-- Gambar Unggulan --}}
            @if($artikel->featured_image)
                <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm text-center">
                    <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-purple-200 inline-flex items-center">
                        <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Gambar Unggulan
                    </h3>
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $artikel->featured_image) }}" alt="{{ $artikel->judul }}" class="mx-auto max-w-full h-auto max-h-96 object-contain rounded-lg shadow-md border border-gray-300">
                    </div>
                </div>
            @else
                <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm text-center">
                    <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-purple-200 inline-flex items-center">
                        <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Gambar Unggulan
                    </h3>
                    <div class="mt-4 bg-gray-100 flex items-center justify-center h-48 rounded-lg border border-gray-300 text-gray-500 text-lg font-medium">
                        Tidak ada gambar unggulan
                    </div>
                </div>
            @endif

            {{-- Bagian Detail Informasi --}}
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-blue-200 flex items-center">
                    <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1c-.027 0-.053 0-.08 0A6 6 0 015.344 4.684 6 6 0 0113 5a6 6 0 01-1 11zm1-1v3m0 0l3-3m-3 3l-3-3m-3 7v3m0 0l3-3m-3 3l-3-3"/>
                    </svg>
                    Detail Informasi Artikel
                </h3>
                <dl class="divide-y divide-gray-200 text-gray-700">
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Judul Artikel</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-gray-800">{{ $artikel->judul }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Slug</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $artikel->slug }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Penulis</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $artikel->author->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Status</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                            @php
                                $statusClass = $artikel->status === 'published' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-800 border border-gray-200';
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($artikel->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Tanggal Publikasi</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                            {{ $artikel->published_at ? \Carbon\Carbon::parse($artikel->published_at)->format('d M Y H:i') : '-' }}
                        </dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Ringkasan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $artikel->excerpt ?? '-' }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Waktu Baca</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $artikel->reading_time }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Jumlah Tayangan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ number_format($artikel->views_count) }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Dibuat Pada</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($artikel->created_at)->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($artikel->updated_at)->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Konten Artikel --}}
            <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-red-200 flex items-center">
                    <svg class="h-6 w-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6v12h12V9m-4 4l-4 4m0-4l4 4"/>
                    </svg>
                    Isi Artikel
                </h3>
                <div class="prose max-w-none text-gray-700">
                    {!! $artikel->konten !!}
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.artikel.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Artikel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection