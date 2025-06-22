@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                    Dashboard Kasir
                </h2>

                {{-- Notifikasi --}}
                @if (Session::has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ Session::get('success') }}</span>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ Session::get('error') }}</span>
                    </div>
                @endif

                {{-- Bagian Statistik Penjualan Kasir --}}
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Ringkasan Penjualan Saya (Hari Ini)</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- Card Total Penjualan Hari Ini --}}
                    <div class="bg-blue-100 p-5 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-700">Total Penjualan Saya Hari Ini</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">Rp {{ number_format($totalPenjualanHariIniKasir, 0, ',', '.') }}</p>
                            <p class="text-xs text-blue-600">{{ $jumlahTransaksiHariIniKasir }} Transaksi</p>
                        </div>
                        <i class="fas fa-cash-register text-blue-500 text-4xl"></i>
                    </div>

                    {{-- Card Total Reservasi Jadwal Hari Ini --}}
                    <div class="bg-green-100 p-5 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-700">Reservasi Jadwal Hari Ini</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">{{ $totalReservasiJadwalHariIni }}</p>
                        </div>
                        <i class="fas fa-calendar-alt text-green-500 text-4xl"></i>
                    </div>
                </div>

                {{-- Informasi Penting Lainnya untuk Kasir --}}
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Informasi Penting</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    {{-- Card Stok Batik Rendah --}}
                    <div class="bg-orange-100 p-5 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-orange-700">Jumlah Jenis Batik Stok Rendah</p>
                            <p class="text-2xl font-bold text-orange-900 mt-1">{{ $jumlahJenisBatikStokRendah }}</p>
                            <p class="text-xs text-orange-600">Perlu perhatian Superadmin!</p>
                        </div>
                        <i class="fas fa-exclamation-triangle text-orange-500 text-4xl"></i>
                    </div>

                    {{-- Link Cepat --}}
                    <div class="bg-gray-100 p-5 rounded-lg shadow-md flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Akses Cepat</p>
                            <div class="mt-2 space-y-2">
                                <a href="{{ route('kasir.pos') }}" class="block text-indigo-600 hover:text-indigo-900 font-medium">
                                    <i class="fas fa-arrow-right mr-2"></i> Buka POS Penjualan
                                </a>
                                <a href="{{ route('kasir.laporan.penjualan.index') }}" class="block text-indigo-600 hover:text-indigo-900 font-medium">
                                    <i class="fas fa-arrow-right mr-2"></i> Lihat Laporan Penjualan Saya
                                </a>
                                <a href="{{ route('kasir.laporan.stok.index') }}" class="block text-indigo-600 hover:text-indigo-900 font-medium">
                                    <i class="fas fa-arrow-right mr-2"></i> Lihat Laporan Stok
                                </a>
                                <a href="{{ route('kasir.laporan.reservasi.index') }}" class="block text-indigo-600 hover:text-indigo-900 font-medium">
                                    <i class="fas fa-arrow-right mr-2"></i> Lihat Laporan Reservasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection