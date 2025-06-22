@extends('layouts.app')

@section('title', 'Detail Penggunaan Bahan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Detail/Mata untuk Penggunaan Bahan --}}
                    <div class="bg-gradient-to-r from-red-500 to-pink-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Penggunaan Bahan</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Informasi lengkap catatan penggunaan bahan ID: <span class="font-semibold text-red-700">{{ $penggunaanBahan->id }}</span></p>
            </div>
        </div>

        {{-- Main Content Card with Details --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-red-200 flex items-center">
                    <svg class="h-6 w-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Informasi Penggunaan
                </h3>
                <dl class="divide-y divide-gray-200 text-gray-700">
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">ID Catatan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-gray-800">{{ $penggunaanBahan->id }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Bahan Baku</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                            <span class="font-semibold">{{ $penggunaanBahan->stockBahan->nama_bahan ?? 'N/A' }}</span> (Kode: <span class="text-gray-500">{{ $penggunaanBahan->stockBahan->kode_bahan ?? 'N/A' }}</span>)
                        </dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Kuantitas Digunakan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-blue-700">
                            {{ $penggunaanBahan->qty_digunakan }} {{ $penggunaanBahan->stockBahan->satuan ?? '' }}
                        </dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Nilai Penggunaan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-green-600">
                            Rp {{ number_format($penggunaanBahan->nilai_penggunaan, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Keperluan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $penggunaanBahan->keperluan }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Keterangan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $penggunaanBahan->keterangan ?? '-' }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Tanggal Penggunaan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($penggunaanBahan->tanggal_penggunaan)->format('d M Y') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Dicatat Oleh</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $penggunaanBahan->user->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Waktu Pencatatan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($penggunaanBahan->created_at)->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Terakhir Diperbarui</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($penggunaanBahan->updated_at)->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.penggunaan_bahan.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('admin.penggunaan_bahan.edit', $penggunaanBahan->id) }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Catatan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection