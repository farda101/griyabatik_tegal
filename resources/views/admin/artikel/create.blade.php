@extends('layouts.app')

@section('title', 'Tambah Artikel Baru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Tetap 7xl untuk konten artikel yang mungkin lebar --}}

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Tambah Artikel --}}
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.523 5.754 18 7.5 18s3.332.477 4.5 1.247m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.523 18.246 18 16.5 18s-3.332.477-4.5 1.247"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Artikel Baru</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Buat artikel edukasi baru untuk dibagikan kepada pembaca Anda.</p>
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
            <form method="POST" action="{{ route('admin.artikel.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                    <input type="text" name="judul" id="judul"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('judul') border-red-500 @enderror"
                        value="{{ old('judul') }}" required autofocus maxlength="255" placeholder="Contoh: Mengenal Lebih Dekat Filosofi Batik">
                    @error('judul')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">Konten Artikel</label>
                    <x-forms.tiny-mce-editor name="konten" id="konten" :value="old('konten')"/>
                    @error('konten')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan (Opsional)</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('excerpt') border-red-500 @enderror"
                        maxlength="300" placeholder="Ringkasan singkat dari artikel ini, maksimal 300 karakter">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Unggulan (Opsional)</label>
                    <input type="file" name="featured_image" id="featured_image"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                @error('featured_image') border-red-500 @enderror"
                        accept="image/*">
                    @error('featured_image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Format yang didukung: JPEG, PNG, JPG, GIF, SVG. Ukuran maksimal: 2MB. Resolusi disarankan: 1200x800px.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Artikel</label>
                        <select name="status" id="status"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('status') border-red-500 @enderror"
                            required>
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi (Opsional)</label>
                        <input type="date" name="published_at" id="published_at"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('published_at') border-red-500 @enderror"
                            value="{{ old('published_at') }}">
                        @error('published_at')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika ingin publikasi segera setelah status "Published".</p>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8">
                    <a href="{{ route('admin.artikel.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 mr-4">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Simpan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Sisipkan komponen konfigurasi TinyMCE di akhir body --}}
@push('scripts')
    <x-head.tiny-mce-config/>
@endpush