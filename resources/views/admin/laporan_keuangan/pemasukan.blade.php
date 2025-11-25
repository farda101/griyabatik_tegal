@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <!-- Page Title and Actions -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ __('Laporan Pemasukan') }}</h1>
                    <p class="text-gray-600 mt-1">{{ __('Laporan pendapatan dari penjualan produk dan workshop') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.laporan_keuangan.pemasukan.export', ['tanggal_dari' => $startDate, 'tanggal_sampai' => $endDate]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ __('Export Excel') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form method="GET" action="{{ route('admin.laporan_keuangan.pemasukan') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Tanggal Dari') }}</label>
                    <input type="date" name="tanggal_dari" value="{{ $startDate }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Tanggal Sampai') }}</label>
                    <input type="date" name="tanggal_sampai" value="{{ $endDate }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200">
                        {{ __('Filter') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Card Penjualan -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold">{{ __('Penjualan Produk') }}</p>
                        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                        <p class="text-blue-100 text-xs mt-1">{{ $jumlahTransaksiPenjualan }} {{ __('transaksi') }}</p>
                    </div>
                    <div class="text-blue-100">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                            <path d="M16 16a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            <path d="M4 18a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card Workshop -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold">{{ __('Pendapatan Workshop') }}</p>
                        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalWorkshop, 0, ',', '.') }}</p>
                        <p class="text-purple-100 text-xs mt-1">{{ $jumlahTransaksiWorkshop }} {{ __('reservasi') }}</p>
                    </div>
                    <div class="text-purple-100">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V6.5m-11-5v5m0 0h5M3.5 6.5h13"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card Total -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold">{{ __('Total Pemasukan') }}</p>
                        <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</p>
                        <p class="text-green-100 text-xs mt-1">{{ $startDateParsed->format('d M Y') }} - {{ $endDateParsed->format('d M Y') }}</p>
                    </div>
                    <div class="text-green-100">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Income Details Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">{{ __('Detail Pemasukan') }}</h3>
            </div>
            
            @if($allIncome->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Tanggal') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Kategori') }}</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Jumlah') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">{{ __('Total (Rp)') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($allIncome as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ \Carbon\Carbon::parse($item['tanggal'])->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $item['tipe'] === 'penjualan' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ $item['kategori'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-gray-700">
                                        {{ $item['jumlah_transaksi'] }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                        Rp {{ number_format($item['total'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-800">{{ __('TOTAL PEMASUKAN') }}</td>
                                <td class="px-6 py-4 text-right text-lg font-bold text-green-600">
                                    Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="mt-4 text-gray-500 text-lg">{{ __('Tidak ada data pemasukan untuk periode ini') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
