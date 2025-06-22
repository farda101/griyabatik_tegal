@extends('layouts.app')

@section('title', 'Detail Video Edukasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Detail/Mata untuk Video Edukasi --}}
                    <div class="bg-gradient-to-r from-red-500 to-orange-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Video Edukasi</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Untuk video: <span class="font-semibold text-orange-700">{{ $video->judul }}</span></p>
            </div>
        </div>

        {{-- Main Content Card with Details --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            {{-- Video Player --}}
            <div class="mb-8 bg-black rounded-lg overflow-hidden shadow-xl border border-gray-200">
                @if($video->file_video)
                    <video controls class="w-full" poster="{{ asset('storage/' . ($video->thumbnail ?? '')) }}" preload="metadata">
                        <source src="{{ asset('storage/' . $video->file_video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="bg-gray-100 flex items-center justify-center h-64 text-gray-500 text-lg font-medium">
                        Tidak ada file video
                    </div>
                @endif
            </div>

            {{-- Bagian Detail Informasi --}}
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-red-200 flex items-center">
                    <svg class="h-6 w-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1c-.027 0-.053 0-.08 0A6 6 0 015.344 4.684 6 6 0 0113 5a6 6 0 01-1 11zm1-1v3m0 0l3-3m-3 3l-3-3m-3 7v3m0 0l3-3m-3 3l-3-3"/>
                    </svg>
                    Detail Informasi Video
                </h3>
                <dl class="divide-y divide-gray-200 text-gray-700">
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">ID Video</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-gray-800">{{ $video->id }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Judul</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $video->judul }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Deskripsi</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $video->deskripsi ?? '-' }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Durasi</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $video->durasi_format }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Jumlah Tayangan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ number_format($video->views_count) }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Status</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                            @php
                                $statusClass = $video->is_active ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200';
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ $video->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Tanggal Dibuat</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($video->created_at)->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($video->updated_at)->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.video.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('admin.video.edit', $video->id) }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Video
                </a>
            </div>
        </div>
    </div>
</div>
@endsection