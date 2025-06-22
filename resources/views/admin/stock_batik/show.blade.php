@extends('layouts.app')

@section('title', 'Detail Stok Batik')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Detail/Mata --}}
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Stok Batik</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Informasi lengkap untuk batik: <span class="font-semibold text-indigo-700">{{ $stockBatik->kode_batik }}</span></p>
            </div>
        </div>

        {{-- Main Content Card with Details --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8"> {{-- Peningkatan gap dan margin-bottom --}}
                {{-- Bagian Detail Informasi Batik --}}
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm"> {{-- Card untuk bagian ini --}}
                    <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-indigo-200 flex items-center">
                        <svg class="h-6 w-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                        Informasi Batik
                    </h3>
                    <dl class="divide-y divide-gray-200 text-gray-700">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Kode Batik</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold">{{ $stockBatik->kode_batik }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Nama Batik</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $stockBatik->nama_batik }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Pengrajin</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $stockBatik->pengrajin->nama_pengrajin ?? 'N/A' }} (<span class="text-gray-500">{{ $stockBatik->pengrajin->kode_pengrajin ?? 'N/A' }}</span>)</dd>
                        </div>
                        <div class="py-3 sm:grid sm-grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Motif</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $stockBatik->motif ?? '-' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Ukuran</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $stockBatik->ukuran ?? '-' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Deskripsi</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $stockBatik->deskripsi ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Bagian Informasi Stok & Harga --}}
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm"> {{-- Card untuk bagian ini --}}
                    <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-green-200 flex items-center">
                        <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Stok & Harga
                    </h3>
                    <dl class="divide-y divide-gray-200 text-gray-700">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Harga Beli</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-gray-800">Rp {{ number_format($stockBatik->harga_beli, 0, ',', '.') }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Harga Jual</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-green-600">Rp {{ number_format($stockBatik->harga_jual, 0, ',', '.') }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Margin</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">Rp {{ number_format($stockBatik->margin, 0, ',', '.') }} (<span class="font-semibold">{{ $stockBatik->margin_persentase }}%</span>)</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Qty Masuk</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $stockBatik->qty_masuk }} Item</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Qty Tersedia</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                <span class="font-bold">{{ $stockBatik->qty_tersedia }} Item</span>
                                @if($stockBatik->is_low_stock)
                                    <span class="ml-2 px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                                        Stok Rendah!
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Qty Terjual</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $stockBatik->qty_terjual }} Item</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Tanggal Masuk</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($stockBatik->tanggal_masuk)->format('d M Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Bagian QR Code --}}
            <div class="mt-8 pt-8 border-t-2 border-gray-100 text-center"> {{-- Border lebih tebal, padding top lebih besar --}}
                <div class="mb-6">
                    <h3 class="font-bold text-xl text-gray-900 mb-2 pb-2 border-b-2 border-red-200 inline-block">
                        <svg class="h-6 w-6 text-red-500 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11H6m0 0l-2 2m2-2l2 2m4-11l4 4m0 0l2-2m-2 2l-2-2m-10 4h12M4 14l2-2m-2 2l-2-2"/>
                        </svg>
                        QR Code Batik
                    </h3>
                </div>
                @if($stockBatik->qr_code)
                    <div class="mb-4 bg-gray-50 p-4 rounded-lg shadow-inner inline-block"> {{-- Kontainer untuk QR Code --}}
                        <img src="{{ asset('storage/' . $stockBatik->qr_code) }}" alt="QR Code {{ $stockBatik->kode_batik }}" class="mx-auto w-56 h-56 md:w-64 md:h-64 border border-gray-300 p-2 rounded shadow-md"> {{-- Ukuran QR Code lebih besar --}}
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('admin.stock_batik.download_qr', $stockBatik->id) }}"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-purple-500 to-indigo-500 hover:from-purple-600 hover:to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Unduh QR Code
                        </a>
                        <p class="text-sm text-gray-500 mt-3">Pastikan QR Code dapat terbaca dengan baik. Ukuran disarankan 200x200px atau lebih besar.</p>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-lg" role="alert">
                        <p class="font-bold">Perhatian!</p>
                        <p class="text-sm">QR Code belum digenerate untuk batik ini. Silakan hubungi pengembang jika ini tidak seharusnya terjadi.</p>
                    </div>
                @endif
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3"> {{-- Peningkatan margin-top dan gap --}}
                <a href="{{ route('admin.stock_batik.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('admin.stock_batik.edit', $stockBatik->id) }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Stok Batik
                </a>
            </div>
        </div>
    </div>
</div>
@endsection