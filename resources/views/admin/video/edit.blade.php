@extends('layouts.app')

@section('title', 'Edit Video Edukasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Edit Video Edukasi --}}
                    <div class="bg-gradient-to-r from-red-500 to-orange-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Video Edukasi</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Mengubah detail untuk video: <span class="font-semibold text-orange-700">{{ $video->judul }}</span></p>
            </div>
        </div>

        {{-- Notifications --}}
        @if ($errors->any())
            <div class="mb-6">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                <strong>Oops!</strong> Ada beberapa masalah dengan input Anda.
                            </p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="mb-6">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                <strong>Gagal!</strong> {{ Session::get('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Content Card with Form --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <form method="POST" action="{{ route('admin.video.update', $video->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Video</label>
                    <input type="text" name="judul" id="judul"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('judul') border-red-500 @enderror"
                        value="{{ old('judul', $video->judul) }}" required autofocus maxlength="255" placeholder="Contoh: Sejarah Batik Indonesia">
                    @error('judul')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('deskripsi') border-red-500 @enderror"
                        maxlength="1000" placeholder="Deskripsi singkat tentang isi video">{{ old('deskripsi', $video->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="file_video" class="block text-sm font-medium text-gray-700 mb-1">Ganti File Video (Opsional)</label>
                    @if($video->file_video)
                        <div class="mb-2 flex items-center space-x-4">
                            <video controls src="{{ asset('storage/' . $video->file_video) }}" class="h-24 w-auto object-cover rounded-lg border border-gray-200 shadow-sm"></video>
                            <div class="flex flex-col">
                                <p class="text-sm text-gray-600">Video saat ini:</p>
                                <a href="{{ asset('storage/' . $video->file_video) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-900 underline mt-1">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Tonton Video
                                </a>
                                <label for="delete_current_video" class="inline-flex items-center text-red-600 mt-2 cursor-pointer">
                                    <input type="checkbox" name="file_action" id="delete_current_video" value="delete_video" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 w-4 h-4">
                                    <span class="ml-1 text-sm">Hapus Video Saat Ini</span>
                                </label>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 mb-2">Tidak ada file video saat ini.</p>
                    @endif
                    <input type="file" name="file_video" id="file_video"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                @error('file_video') border-red-500 @enderror"
                        accept="video/*">
                    @error('file_video')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti. Format yang didukung: MP4, MOV, AVI, WEBM. Ukuran maksimal: 500MB.</p>
                </div>

                <div class="mb-6">
                    <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Ganti File Thumbnail (Opsional)</label>
                    @if($video->thumbnail)
                        <div class="mb-2 flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Current Thumbnail" class="h-16 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex flex-col">
                                <p class="text-sm text-gray-600">Thumbnail saat ini:</p>
                                <a href="{{ asset('storage/' . $video->thumbnail) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-900 underline mt-1">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Lihat Thumbnail
                                </a>
                                <label for="delete_current_thumbnail" class="inline-flex items-center text-red-600 mt-2 cursor-pointer">
                                    <input type="checkbox" name="file_action" id="delete_current_thumbnail" value="delete_thumbnail" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 w-4 h-4">
                                    <span class="ml-1 text-sm">Hapus Thumbnail Saat Ini</span>
                                </label>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 mb-2">Tidak ada thumbnail saat ini.</p>
                    @endif
                    <input type="file" name="thumbnail" id="thumbnail"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                @error('thumbnail') border-red-500 @enderror"
                        accept="image/*">
                    @error('thumbnail')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti. Format yang didukung: JPEG, PNG, JPG, GIF, SVG. Ukuran maksimal: 2MB. Resolusi disarankan: 16:9 ratio.</p>
                </div>

                <div class="mb-6">
                    <label for="durasi_detik" class="block text-sm font-medium text-gray-700 mb-1">Durasi (Detik)</label>
                    <input type="number" name="durasi_detik" id="durasi_detik"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('durasi_detik') border-red-500 @enderror"
                        value="{{ old('durasi_detik', $video->durasi_detik) }}" required min="1" placeholder="Contoh: 180 (untuk 3 menit)">
                    @error('durasi_detik')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5"
                        {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-base font-medium text-gray-800">Aktif (Tampilkan di Halaman Publik)</label>
                    @error('is_active')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Views Count (Display Only) --}}
                <div class="mb-6">
                    <label for="views_count_display" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tayangan</label>
                    <input type="text" id="views_count_display"
                        class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                        value="{{ number_format($video->views_count) }}" readonly>
                </div>

                <div class="flex items-center justify-end mt-8">
                    <a href="{{ route('admin.video.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 mr-4">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Update Video Edukasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection