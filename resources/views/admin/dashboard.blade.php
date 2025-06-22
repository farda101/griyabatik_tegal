@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Admin</h1>
                        <p class="text-gray-600">Selamat datang kembali! Kelola bisnis batik Anda dengan mudah.</p>
                    </div>
                    <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Terakhir diperbarui</p>
                            <p class="text-sm font-semibold text-gray-700">{{ now()->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
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

        {{-- Sales Statistics Section --}}
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <div class="flex items-center">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Statistik Penjualan</h2>
                </div>
                <a href="{{ route('admin.laporan.penjualan.export') }}" 
                   class="mt-3 sm:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Laporan
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                {{-- Today's Sales Card --}}
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-blue-100 text-sm font-medium mb-1">Penjualan Hari Ini</p>
                            <p class="text-3xl font-bold mb-2">Rp {{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</p>
                            <div class="flex items-center text-blue-200 text-sm">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                {{ $jumlahTransaksiHariIni }} Transaksi
                            </div>
                        </div>
                        <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Monthly Sales Card --}}
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-indigo-100 text-sm font-medium mb-1">Penjualan Bulan Ini</p>
                            <p class="text-3xl font-bold mb-2">Rp {{ number_format($totalPenjualanBulanIni, 0, ',', '.') }}</p>
                            <div class="flex items-center text-indigo-200 text-sm">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                {{ $jumlahTransaksiBulanIni }} Transaksi
                            </div>
                        </div>
                        <div class="bg-indigo-400 bg-opacity-30 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Sales Card --}}
                <div class="bg-gradient-to-br from-cyan-500 to-teal-600 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-6 text-white md:col-span-2 xl:col-span-1">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-cyan-100 text-sm font-medium mb-1">Total Penjualan</p>
                            <p class="text-3xl font-bold mb-2">Rp {{ number_format($totalPenjualanKeseluruhan, 0, ',', '.') }}</p>
                            <div class="flex items-center text-cyan-200 text-sm">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                {{ $jumlahTransaksiKeseluruhan }} Transaksi
                            </div>
                        </div>
                        <div class="bg-cyan-400 bg-opacity-30 rounded-full p-3">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reservation Statistics Section --}}
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-2 rounded-lg mr-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Statistik Reservasi</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Today's Reservations --}}
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Reservasi Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalReservasiHariIni }}</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Pending Reservations --}}
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Reservasi Pending</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalReservasiPending }}</p>
                        </div>
                        <div class="bg-yellow-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Paid Reservations --}}
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Reservasi Lunas</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalReservasiPaid }}</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Reservations --}}
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border-l-4 border-gray-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Reservasi</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalReservasiKeseluruhan }}</p>
                        </div>
                        <div class="bg-gray-100 rounded-full p-3">
                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inventory Statistics Section --}}
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 p-2 rounded-lg mr-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Statistik Stok Inventaris</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Batik Stock Card --}}
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="bg-red-100 rounded-full p-2 mr-3">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Stok Batik</h3>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalBatikTersedia }} <span class="text-lg font-normal text-gray-600">Item</span></p>
                            <p class="text-sm text-gray-600 mb-3">Nilai: Rp {{ number_format($totalNilaiBatikTersedia, 0, ',', '.') }}</p>
                            
                            @if($jumlahJenisBatikStokRendah > 0)
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-sm font-medium text-red-800">
                                            {{ $jumlahJenisBatikStokRendah }} Jenis Batik Stok Rendah!
                                        </p>
                                    </div>
                                    <p class="text-xs text-red-600 mt-1">(di bawah {{ $minStockAlertBatik }} item)</p>
                                </div>
                            @else
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-sm font-medium text-green-800">Stok batik dalam kondisi baik</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Material Stock Card --}}
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 p-6 border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="bg-orange-100 rounded-full p-2 mr-3">
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Stok Bahan</h3>
                            </div>
                            <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalBahanTersedia }} <span class="text-lg font-normal text-gray-600">Unit</span></p>
                            <p class="text-sm text-gray-600 mb-3">Nilai: Rp {{ number_format($totalNilaiBahanTersedia, 0, ',', '.') }}</p>
                            
                            @if($jumlahJenisBahanStokRendah > 0)
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-sm font-medium text-red-800">
                                            {{ $jumlahJenisBahanStokRendah }} Jenis Bahan Stok Rendah!
                                        </p>
                                    </div>
                                    <p class="text-xs text-red-600 mt-1">(di bawah {{ $minStockAlertBahan }} unit)</p>
                                </div>
                            @else
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <p class="text-sm font-medium text-green-800">Stok bahan dalam kondisi baik</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        ---
        
        {{-- Quick Actions Section --}}
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-2 rounded-lg mr-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Aksi Cepat</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                <a href="{{ route('admin.pengrajin.create') }}" 
                   class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-5 flex flex-col items-center text-center border border-gray-100">
                    <div class="bg-blue-100 rounded-full p-3 mb-3">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V8a2 2 0 00-2-2h-2M9 16a2 2 0 11-4 0 2 2 0 014 0zM12 21h4m-4 0v-4a2 2 0 012-2h2a2 2 0 012 2v4m-4-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002-2v-4z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Tambah Pengrajin</span>
                    <p class="text-sm text-gray-600 mt-1">Daftarkan pengrajin baru ke sistem.</p>
                </a>

                <a href="{{ route('admin.stock_batik.create') }}" 
                   class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-5 flex flex-col items-center text-center border border-gray-100">
                    <div class="bg-purple-100 rounded-full p-3 mb-3">
                        <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Tambah Stok Batik</span>
                    <p class="text-sm text-gray-600 mt-1">Tambahkan item batik baru ke inventaris.</p>
                </a>

                <a href="{{ route('admin.stock_bahan.create') }}" 
                   class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-5 flex flex-col items-center text-center border border-gray-100">
                    <div class="bg-yellow-100 rounded-full p-3 mb-3">
                        <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Tambah Stok Bahan</span>
                    <p class="text-sm text-gray-600 mt-1">Catat bahan baku baru yang masuk.</p>
                </a>

                <a href="{{ route('admin.reservasi.index') }}" 
                   class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-5 flex flex-col items-center text-center border border-gray-100">
                    <div class="bg-green-100 rounded-full p-3 mb-3">
                        <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Kelola Reservasi</span>
                    <p class="text-sm text-gray-600 mt-1">Lihat dan atur semua reservasi pelanggan.</p>
                </a>

                <a href="{{ route('kasir.pos') }}" 
                   class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 p-5 flex flex-col items-center text-center border border-gray-100">
                    <div class="bg-red-100 rounded-full p-3 mb-3">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold text-gray-800">Buka POS Kasir</span>
                    <p class="text-sm text-gray-600 mt-1">Mulai transaksi penjualan baru.</p>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

{{-- No need for Font Awesome CDN if using Heroicons SVG directly --}}
{{-- @push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlalTjs/P4V9+q/k3S2C6y1i4y1tQ6k8+V5vA3r5q3r5p5q5r5s5t5u5v5w5x5y5z5A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush --}}