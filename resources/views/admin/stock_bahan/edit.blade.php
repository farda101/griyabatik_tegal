@extends('layouts.app')

@section('title', 'Edit Stok Bahan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Edit Bahan --}}
                    <div class="bg-gradient-to-r from-orange-500 to-yellow-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Stok Bahan</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Mengubah data untuk bahan: <span class="font-semibold text-orange-700">{{ $stockBahan->nama_bahan }} ({{ $stockBahan->kode_bahan }})</span></p>
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
            <form method="POST" action="{{ route('admin.stock_bahan.update', $stockBahan->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kode_bahan_display" class="block text-sm font-medium text-gray-700 mb-1">Kode Bahan</label>
                        <input type="text" name="kode_bahan_display" id="kode_bahan_display"
                            class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                            value="{{ $stockBahan->kode_bahan }}" readonly>
                        {{-- Hidden input untuk memastikan kode_bahan tetap terkirim --}}
                        <input type="hidden" name="kode_bahan" value="{{ $stockBahan->kode_bahan }}">
                    </div>

                    <div>
                        <label for="nama_bahan" class="block text-sm font-medium text-gray-700 mb-1">Nama Bahan</label>
                        <input type="text" name="nama_bahan" id="nama_bahan"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('nama_bahan') border-red-500 @enderror"
                            value="{{ old('nama_bahan', $stockBahan->nama_bahan) }}" required maxlength="255" placeholder="Contoh: Kain Katun Primisima">
                        @error('nama_bahan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                        <input type="text" name="satuan" id="satuan"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('satuan') border-red-500 @enderror"
                            value="{{ old('satuan', $stockBahan->satuan) }}" required maxlength="50" placeholder="Contoh: meter, kg, pcs">
                        @error('satuan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="harga_satuan" class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan</label>
                        <input type="number" name="harga_satuan" id="harga_satuan"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('harga_satuan') border-red-500 @enderror"
                            value="{{ old('harga_satuan', $stockBahan->harga_satuan) }}" required min="0" step="0.01" placeholder="Contoh: 10000">
                        @error('harga_satuan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="qty_masuk_display" class="block text-sm font-medium text-gray-700 mb-1">Kuantitas Masuk Awal</label>
                        <input type="number" name="qty_masuk_display" id="qty_masuk_display"
                            class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                            value="{{ $stockBahan->qty_masuk }}" readonly>
                        {{-- Hidden input untuk memastikan nilai qty_masuk tetap terkirim --}}
                        <input type="hidden" name="qty_masuk" value="{{ $stockBahan->qty_masuk }}">
                    </div>

                    <div>
                        <label for="qty_tersedia_display" class="block text-sm font-medium text-gray-700 mb-1">Kuantitas Tersedia</label>
                        <input type="number" name="qty_tersedia_display" id="qty_tersedia_display"
                            class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                            value="{{ $stockBahan->qty_tersedia }}" readonly>
                        @if($stockBahan->is_low_stock)
                            <p class="mt-1 text-xs text-orange-600">Stok bahan ini sudah rendah!</p>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="qty_terpakai_display" class="block text-sm font-medium text-gray-700 mb-1">Kuantitas Terpakai</label>
                        <input type="number" name="qty_terpakai_display" id="qty_terpakai_display"
                            class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                            value="{{ $stockBahan->qty_terpakai }}" readonly>
                    </div>

                    <div>
                        <label for="total_harga_display" class="block text-sm font-medium text-gray-700 mb-1">Total Nilai Stok</label>
                        <input type="text" name="total_harga_display" id="total_harga_display"
                            class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                            value="Rp {{ number_format($stockBahan->total_harga, 0, ',', '.') }}" readonly>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('tanggal_masuk') border-red-500 @enderror"
                        value="{{ old('tanggal_masuk', \Carbon\Carbon::parse($stockBahan->tanggal_masuk)->format('Y-m-d')) }}" required>
                    @error('tanggal_masuk')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('keterangan') border-red-500 @enderror"
                        maxlength="1000" placeholder="Catatan tambahan tentang bahan ini">{{ old('keterangan', $stockBahan->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-8">
                    <a href="{{ route('admin.stock_bahan.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 mr-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Update Stok Bahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection