@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{-- Tetap 7xl untuk konten artikel yang mungkin lebar --}}

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Edit Artikel --}}
                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Artikel</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Mengubah artikel: <span class="font-semibold text-blue-700">{{ $artikel->judul }}</span></p>
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
            <form method="POST" action="{{ route('admin.artikel.update', $artikel->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                    <input type="text" name="judul" id="judul"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('judul') border-red-500 @enderror"
                        value="{{ old('judul', $artikel->judul) }}" required autofocus maxlength="255" placeholder="Contoh: Mengenal Lebih Dekat Filosofi Batik">
                    @error('judul')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="konten" class="block text-sm font-medium text-gray-700 mb-1">Konten Artikel</label>
                    <x-forms.tiny-mce-editor name="konten" id="konten" :value="old('konten', $artikel->konten)"/>
                    @error('konten')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan (Opsional)</label>
                    <textarea name="excerpt" id="excerpt" rows="2"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('excerpt') border-red-500 @enderror"
                        maxlength="300" placeholder="Ringkasan singkat dari artikel ini, maksimal 300 karakter">{{ old('excerpt', $artikel->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar Unggulan (Opsional)</label>
                    @if($artikel->featured_image)
                        <div class="mb-2 flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $artikel->featured_image) }}" alt="Current Featured Image" class="h-24 w-auto object-cover rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex flex-col">
                                <p class="text-sm text-gray-600">Gambar saat ini:</p>
                                <a href="{{ asset('storage/' . $artikel->featured_image) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-900 underline mt-1">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Lihat Gambar
                                </a>
                                <label for="delete_featured_image" class="inline-flex items-center text-red-600 mt-2 cursor-pointer">
                                    <input type="checkbox" name="file_action" id="delete_featured_image" value="delete_featured_image" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 w-4 h-4">
                                    <span class="ml-1 text-sm">Hapus Gambar Ini</span>
                                </label>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 mb-2">Tidak ada gambar unggulan saat ini.</p>
                    @endif
                    <input type="file" name="featured_image" id="featured_image"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                @error('featured_image') border-red-500 @enderror"
                        accept="image/*">
                    @error('featured_image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti. Format yang didukung: JPEG, PNG, JPG, GIF, SVG. Ukuran maksimal: 2MB.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Artikel</label>
                        <select name="status" id="status"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('status') border-red-500 @enderror"
                            required>
                            <option value="draft" {{ old('status', $artikel->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $artikel->status) == 'published' ? 'selected' : '' }}>Published</option>
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
                            value="{{ old('published_at', $artikel->published_at ? \Carbon\Carbon::parse($artikel->published_at)->format('Y-m-d') : '') }}">
                        @error('published_at')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika ingin publikasi segera setelah status "Published".</p>
                    </div>
                </div>

                {{-- Penulis (Display Only) --}}
                <div class="mb-6 mt-6">
                    <label for="author_display" class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                    <input type="text" id="author_display"
                        class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                        value="{{ $artikel->author->name ?? 'N/A' }}" readonly>
                </div>

                {{-- Views Count (Display Only) --}}
                <div class="mb-6">
                    <label for="views_count_display" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tayangan</label>
                    <input type="text" id="views_count_display"
                        class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                        value="{{ number_format($artikel->views_count) }}" readonly>
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
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Update Artikel
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