@extends('layouts.app')

@section('title', 'Manajemen Stok Batik')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div class="flex items-center">
                        {{-- Ikon Stok Batik --}}
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-2 rounded-lg mr-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900">Manajemen Stok Batik</h1>
                    </div>
                    <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.stock_batik.create') }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Stok Batik
                        </a>
<<<<<<< HEAD
=======
                        <a href="{{ route('admin.stock_batik.export') }}"
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export Excel
                        </a>
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter dan Export Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center mb-2 sm:mb-0">
                        <svg class="h-6 w-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter & Export Data
                    </h2>
                    @if(request('tanggal_dari') || request('tanggal_sampai'))
                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 border border-blue-300 rounded-lg">
                            <svg class="h-5 w-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a1 1 0 011-1h8a1 1 0 011 1v2a1 1 0 11-2 0V8H7v1a1 1 0 11-2 0zm0 4a1 1 0 011-1h8a1 1 0 011 1v2a1 1 0 11-2 0v-1H7v1a1 1 0 11-2 0v-2z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold text-blue-900">
                                Filter Aktif:
                                @if(request('tanggal_dari') && request('tanggal_sampai'))
                                    {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d M Y') }}
                                @elseif(request('tanggal_dari'))
                                    Dari {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d M Y') }}
                                @else
                                    Sampai {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d M Y') }}
                                @endif
                            </span>
                        </div>
                    @endif
                </div>
                
                <form method="GET" action="{{ route('admin.stock_batik.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- Tanggal Dari --}}
                        <div>
                            <label for="tanggal_dari" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Dari
                            </label>
                            <input 
                                type="date" 
                                id="tanggal_dari" 
                                name="tanggal_dari" 
                                value="{{ request('tanggal_dari') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            >
                        </div>

                        {{-- Tanggal Sampai --}}
                        <div>
                            <label for="tanggal_sampai" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Sampai
                            </label>
                            <input 
                                type="date" 
                                id="tanggal_sampai" 
                                name="tanggal_sampai" 
                                value="{{ request('tanggal_sampai') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            >
                        </div>

                        {{-- Button Terapkan Filter --}}
                        <div class="flex items-end">
                            <button 
                                type="submit" 
                                class="w-full px-6 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-200">
                                <svg class="h-5 w-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Terapkan
                            </button>
                        </div>

                        {{-- Button Reset Filter --}}
                        <div class="flex items-end">
                            <a 
                                href="{{ route('admin.stock_batik.index') }}" 
                                class="w-full px-6 py-2 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-200 text-center">
                                <svg class="h-5 w-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                {{-- Export Button dengan Filter --}}
                <div class="mt-4 flex flex-col sm:flex-row gap-3">
                    <button 
                        id="exportWithFilterBtn"
                        onclick="exportWithFilter()"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Excel dengan Filter
                    </button>
                    <a 
                        href="{{ route('admin.stock_batik.export') }}"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Semua Data
                    </a>
                </div>
            </div>
        </div>

        {{-- Notifications --}}
        @if (Session::has('success'))
            <div class="mb-6">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                <strong>Berhasil!</strong> {{ Session::get('success') }}
                            </p>
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

        {{-- Main Content Card --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            {{-- Data Summary --}}
            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="h-5 w-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                            Total Data: <span class="text-blue-600 ml-1">{{ $stockBatiks->count() }} item</span>
                        </h3>
                        @if(request('tanggal_dari') || request('tanggal_sampai'))
                            <p class="text-sm text-gray-600 mt-1">
                                Periode: 
                                @if(request('tanggal_dari') && request('tanggal_sampai'))
                                    <strong>{{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d M Y') }}</strong> hingga <strong>{{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d M Y') }}</strong>
                                @elseif(request('tanggal_dari'))
                                    Dari <strong>{{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d M Y') }}</strong>
                                @else
                                    Sampai <strong>{{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d M Y') }}</strong>
                                @endif
                            </p>
                        @endif
                    </div>
                    @if(request('tanggal_dari') || request('tanggal_sampai'))
                        <div class="mt-3 sm:mt-0">
                            <a href="{{ route('admin.stock_batik.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition duration-200">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Hapus Filter
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="stockBatikTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-lg">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Kode Batik
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Nama Batik
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Pengrajin
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Harga Jual
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Qty Tersedia
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Tgl. Masuk
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-lg">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($stockBatiks as $index => $batik)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $batik->kode_batik }}
                                    @if($batik->is_low_stock)
                                        <span class="ml-2 px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                                            Stok Rendah!
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $batik->nama_batik }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $batik->pengrajin->nama_pengrajin ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-order="{{ $batik->harga_jual }}">
                                    Rp {{ number_format($batik->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $batik->qty_tersedia }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700" data-order="{{ $batik->tanggal_masuk }}">
                                    {{ \Carbon\Carbon::parse($batik->tanggal_masuk)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.stock_batik.show', $batik->id) }}" class="text-blue-600 hover:text-blue-900 mr-4 transition duration-150 ease-in-out">
                                        <svg class="h-5 w-5 inline-block -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.stock_batik.edit', $batik->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 transition duration-150 ease-in-out">
                                        <svg class="h-5 w-5 inline-block -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    @if($batik->qr_code)
                                        <a href="{{ route('admin.stock_batik.download_qr', $batik->id) }}" class="text-purple-600 hover:text-purple-900 mr-4 transition duration-150 ease-in-out">
                                            <svg class="h-5 w-5 inline-block -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download QR
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.stock_batik.destroy', $batik->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus stok batik ini? Jika sudah ada dalam penjualan, tidak bisa dihapus. Aksi ini tidak dapat dibatalkan!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                            <svg class="h-5 w-5 inline-block -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- DataTables CSS --}}
@push('styles')
<<<<<<< HEAD
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
    /* DataTables Wrapper Styling */
    .dataTables_wrapper {
        @apply text-gray-700;
    }

    /* Length and Filter Controls */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        @apply mb-4 text-sm;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        @apply flex items-center gap-2 font-medium;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        @apply px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm;
    }

    /* Info Section */
    .dataTables_wrapper .dataTables_info {
        @apply text-sm text-gray-600 pt-4;
    }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate {
        @apply pt-4 text-sm flex justify-center sm:justify-end;
    }

    .dataTables_wrapper .paginate_button {
        @apply px-3 py-2 mx-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out cursor-pointer;
    }

    .dataTables_wrapper .paginate_button.current,
    .dataTables_wrapper .paginate_button.current:hover {
        @apply bg-gradient-to-r from-indigo-500 to-indigo-600 text-white border-indigo-500 hover:from-indigo-600 hover:to-indigo-700;
    }

    .dataTables_wrapper .paginate_button.disabled,
    .dataTables_wrapper .paginate_button.disabled:hover,
    .dataTables_wrapper .paginate_button.disabled:active {
        @apply opacity-50 cursor-not-allowed bg-gray-100 text-gray-400;
    }

    /* Processing */
    .dataTables_wrapper .dataTables_processing {
        @apply fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 bg-white px-6 py-4 rounded-xl shadow-2xl border border-gray-200;
    }

    .dataTables_wrapper .dataTables_processing::after {
        content: "Sedang memproses...";
        @apply block text-center text-gray-700 font-medium;
    }

    /* Scrolling */
    .dataTables_scroll {
        @apply overflow-x-auto;
    }

    /* Additional spacing improvements */
    .dataTables_wrapper > div:first-child {
        @apply mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4;
    }

    .dataTables_wrapper > div:last-child {
        @apply mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4;
=======
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.min.css">
<style>
    /* Custom DataTables styling */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        @apply border border-gray-300 rounded-lg px-3 py-2 text-sm;
    }
    
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        @apply text-sm text-gray-700;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        @apply px-3 py-2 ml-1 text-sm border border-gray-300 rounded bg-white hover:bg-gray-50;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-blue-500 text-white border-blue-500 hover:bg-blue-600;
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
    }
</style>
@endpush

{{-- DataTables JS --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<<<<<<< HEAD

<script>
$(document).ready(function() {
    const table = $('#stockBatikTable').DataTable({
=======
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>

<script>
$(document).ready(function() {
    $('#stockBatikTable').DataTable({
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
        // Basic configuration
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
        
        // Language configuration
        language: {
            "sEmptyTable": "Belum ada data stok batik",
            "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ total entri)",
<<<<<<< HEAD
=======
            "sInfoPostFix": "",
            "sInfoThousands": ".",
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
            "sLengthMenu": "Tampilkan _MENU_ entri",
            "sLoadingRecords": "Sedang memuat...",
            "sProcessing": "Sedang memproses...",
            "sSearch": "Cari:",
            "sSearchPlaceholder": "Cari nama, kode, pengrajin...",
<<<<<<< HEAD
=======
            "sThousands": ".",
            "sUrl": "",
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "oPaginate": {
                "sFirst": "Pertama",
                "sLast": "Terakhir",
<<<<<<< HEAD
                "sNext": "Berikutnya",
                "sPrevious": "Sebelumnya"
=======
                "sNext": "Selanjutnya",
                "sPrevious": "Sebelumnya"
            },
            "oAria": {
                "sSortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                "sSortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
            }
        },
        
        // Column configuration
        columnDefs: [
            {
                targets: 0, // No column
                orderable: false,
<<<<<<< HEAD
                searchable: false,
                width: '5%'
            },
            {
                targets: 1, // Kode Batik
                width: '12%'
            },
            {
                targets: 2, // Nama Batik
                width: '18%'
            },
            {
                targets: 3, // Pengrajin
                width: '15%'
            },
            {
                targets: 4, // Harga Jual
                type: 'num',
                width: '12%'
            },
            {
                targets: 5, // Qty Tersedia
                width: '10%'
            },
            {
                targets: 6, // Tanggal Masuk
                type: 'date',
                width: '12%'
=======
                searchable: false
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
            },
            {
                targets: -1, // Action column
                orderable: false,
<<<<<<< HEAD
                searchable: false,
                width: '16%'
=======
                searchable: false
            },
            {
                targets: 4, // Harga Jual column
                type: 'num'
            },
            {
                targets: 6, // Tanggal Masuk column
                type: 'date'
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
            }
        ],
        
        // Default sorting by date (newest first)
        order: [[6, 'desc']],
        
        // Responsive
        responsive: true,
        
        // Custom search delay
        searchDelay: 500,
        
<<<<<<< HEAD
        // DOM layout - improved
        dom: '<"flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-4"<"flex flex-col sm:flex-row gap-2"l><"w-full sm:w-auto"f>>rt<"flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mt-4"<"text-sm text-gray-600"i><"flex gap-2"p>>',
        
        // Custom initialization
        initComplete: function(settings, json) {
            // Enhance search input
            const searchInput = $('.dataTables_filter input');
            searchInput.attr('placeholder', 'Cari nama, kode, pengrajin...')
                      .addClass('w-full sm:w-64');
            
            // Enhance length select
            const lengthSelect = $('.dataTables_length select');
            lengthSelect.addClass('w-full sm:w-auto');
            
            // Add icons to pagination buttons
            $('.dataTables_paginate .paginate_button').each(function() {
                const $btn = $(this);
                if ($btn.text() === 'Pertama') {
                    $btn.html('<svg class="h-4 w-4 inline" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M4 10a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>');
                } else if ($btn.text() === 'Sebelumnya') {
                    $btn.html('<svg class="h-4 w-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Sebelumnya');
                } else if ($btn.text() === 'Berikutnya') {
                    $btn.html('Berikutnya <svg class="h-4 w-4 inline ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>');
                } else if ($btn.text() === 'Terakhir') {
                    $btn.html('<svg class="h-4 w-4 inline" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M16 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1z" clip-rule="evenodd"/></svg>');
                }
            });
        }
    });
    
    // Add row striping on hover
    $('#stockBatikTable tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('bg-blue-50');
    }).on('mouseleave', 'tr', function() {
        $(this).removeClass('bg-blue-50');
    });
});

// Function untuk export dengan filter tanggal
function exportWithFilter() {
    const tanggalDari = document.getElementById('tanggal_dari').value;
    const tanggalSampai = document.getElementById('tanggal_sampai').value;
    
    // Validasi bahwa minimal ada satu tanggal yang dipilih
    if (!tanggalDari && !tanggalSampai) {
        alert('Silakan pilih minimal satu tanggal (Dari atau Sampai)');
        return;
    }
    
    // Validasi bahwa tanggal dari tidak lebih besar dari tanggal sampai
    if (tanggalDari && tanggalSampai && tanggalDari > tanggalSampai) {
        alert('Tanggal Dari tidak boleh lebih besar dari Tanggal Sampai');
        return;
    }
    
    // Build URL dengan query parameters
    let url = '{{ route("admin.stock_batik.export") }}?';
    const params = [];
    
    if (tanggalDari) {
        params.push('tanggal_dari=' + tanggalDari);
    }
    if (tanggalSampai) {
        params.push('tanggal_sampai=' + tanggalSampai);
    }
    
    url += params.join('&');
    
    // Redirect ke export URL
    window.location.href = url;
}
=======
        // DOM layout
        dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col sm:flex-row justify-between items-center mt-4"ip>',
        
        // Custom initialization
        initComplete: function() {
            // Add custom styling after initialization
            $('.dataTables_filter input').attr('placeholder', 'Cari nama, kode, pengrajin...');
        }
    });
});
>>>>>>> 903583dba47c81235784b0eb5f8c2866eaef41f8
</script>
@endpush
@endsection