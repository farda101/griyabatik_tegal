@extends('layouts.public')

@section('title', 'Cek Status Reservasi')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 p-8 text-white text-center">
                <h2 class="font-bold text-3xl mb-2">
                    Cek Status Reservasi Anda
                </h2>
                <p class="text-purple-100 text-lg">Masukkan nomor reservasi Anda untuk melihat status terbaru.</p>
            </div>

            <div class="p-8">
                {{-- Notifikasi Sukses/Error --}}
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
                {{-- Notifikasi Error Validasi (jika ada kesalahan validasi) --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Oops! Ada masalah:</strong>
                        <ul class="mt-3 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('reservasi.status') }}" class="space-y-6">
                    @csrf

                    <div class="mb-5">
                        <label for="nomor_reservasi" class="block text-sm font-medium text-gray-700 mb-1">Nomor Reservasi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="nomor_reservasi" id="nomor_reservasi"
                                class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-base transition duration-150 ease-in-out placeholder-gray-400
                                @error('nomor_reservasi') border-red-500 @enderror"
                                value="{{ old('nomor_reservasi') }}" required autofocus maxlength="15" placeholder="Contoh: RSV250625001">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2v5a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2h6zM15 7V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v3m4 8h.01M9 11h.01"/>
                                </svg>
                            </div>
                        </div>
                        @error('nomor_reservasi')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-center pt-4">
                        <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cek Status
                        </button>
                    </div>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-200 text-center text-base text-gray-600">
                    <p class="mb-2">Belum punya nomor reservasi?</p>
                    <a href="{{ route('reservasi.create') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-semibold transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Daftar Workshop Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection