@extends('layouts.app')

@section('title', 'Tambah Stok Batik Baru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Tambah Stok Batik --}}
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Stok Batik Baru</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Isi formulir di bawah untuk menambahkan item batik baru ke inventaris.</p>
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
            <form method="POST" action="{{ route('admin.stock_batik.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="pengrajin_id" class="block text-sm font-medium text-gray-700 mb-1">Pengrajin</label>
                        <select name="pengrajin_id" id="pengrajin_id"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('pengrajin_id') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Pengrajin --</option>
                            @foreach ($pengrajins as $pengrajin)
                                <option value="{{ $pengrajin->id }}" {{ old('pengrajin_id') == $pengrajin->id ? 'selected' : '' }}>
                                    {{ $pengrajin->nama_pengrajin }} ({{ $pengrajin->kode_pengrajin }})
                                </option>
                            @endforeach
                        </select>
                        @error('pengrajin_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_batik" class="block text-sm font-medium text-gray-700 mb-1">Nama Batik</label>
                        <input type="text" name="nama_batik" id="nama_batik"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('nama_batik') border-red-500 @enderror"
                            value="{{ old('nama_batik') }}" required autofocus maxlength="255" placeholder="Contoh: Batik Parang Rusak">
                        @error('nama_batik')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('deskripsi') border-red-500 @enderror"
                        maxlength="1000" placeholder="Deskripsi singkat tentang batik ini">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="motif" class="block text-sm font-medium text-gray-700 mb-1">Motif (Opsional)</label>
                        <input type="text" name="motif" id="motif"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('motif') border-red-500 @enderror"
                            value="{{ old('motif') }}" maxlength="100" placeholder="Contoh: Parang, Kawung">
                        @error('motif')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ukuran" class="block text-sm font-medium text-gray-700 mb-1">Ukuran (Opsional)</label>
                        <input type="text" name="ukuran" id="ukuran"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('ukuran') border-red-500 @enderror"
                            value="{{ old('ukuran') }}" maxlength="50" placeholder="Contoh: 2m x 1.5m">
                        @error('ukuran')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="harga_beli" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('harga_beli') border-red-500 @enderror"
                            value="{{ old('harga_beli') }}" required min="0" step="0.01" placeholder="Contoh: 100000">
                        @error('harga_beli')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('harga_jual') border-red-500 @enderror"
                            value="{{ old('harga_jual') }}" required min="0" step="0.01" placeholder="Contoh: 150000">
                        @error('harga_jual')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="qty_masuk" class="block text-sm font-medium text-gray-700 mb-1">Kuantitas Masuk</label>
                        <input type="number" name="qty_masuk" id="qty_masuk"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('qty_masuk') border-red-500 @enderror"
                            value="{{ old('qty_masuk') }}" required min="1" placeholder="Contoh: 10">
                        @error('qty_masuk')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('tanggal_masuk') border-red-500 @enderror"
                            value="{{ old('tanggal_masuk', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                        @error('tanggal_masuk')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8">
                    <a href="{{ route('admin.stock_batik.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 mr-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Simpan Stok Batik
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection