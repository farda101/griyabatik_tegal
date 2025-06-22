@extends('layouts.app')

@section('title', 'Detail Penjualan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Detail Penjualan --}}
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Penjualan</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Informasi lengkap untuk transaksi nomor nota: <span class="font-semibold text-blue-700">{{ $penjualan->nomor_nota }}</span></p>
            </div>
        </div>

        {{-- Main Content Card (untuk Detail Penjualan) --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            {{-- Bagian Informasi Umum Penjualan --}}
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm mb-8">
                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-indigo-200 flex items-center">
                    <svg class="h-6 w-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7v3m0-3h3m-3 0h-3m-3 7v3m0-3h3"/>
                    </svg>
                    Informasi Penjualan
                </h3>
                <dl class="divide-y divide-gray-200 text-gray-700">
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Nomor Nota</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-gray-800">{{ $penjualan->nomor_nota }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Tanggal Penjualan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Kasir</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $penjualan->kasir->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Nama Pembeli</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $penjualan->nama_pembeli }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Telepon Pembeli</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $penjualan->telepon_pembeli ?? '-' }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Total Harga</dt>
                        <dd class="mt-1 text-lg sm:col-span-2 sm:mt-0 font-bold text-green-600">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Total Dibayar</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">Rp {{ number_format($penjualan->total_bayar, 0, ',', '.') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Kembalian</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</dd>
                    </div>
                    <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium">Total Keuntungan</dt>
                        <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-blue-700">Rp {{ number_format($penjualan->total_keuntungan, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Detail Item Penjualan --}}
            <div class="mt-8 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-purple-200 flex items-center">
                    <svg class="h-6 w-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Item Terjual
                </h3>
                <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-lg">Batik</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pengrajin</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-lg">Keuntungan Item</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($penjualan->detailPenjualans as $detail)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $detail->stockBatik->nama_batik ?? 'N/A' }} (<span class="text-gray-500">{{ $detail->stockBatik->kode_batik ?? 'N/A' }}</span>)
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $detail->stockBatik->pengrajin->nama_pengrajin ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $detail->qty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        Rp {{ number_format($detail->keuntungan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                        Tidak ada item yang terjual untuk transaksi ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('kasir.laporan.penjualan.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                    </svg>
                    Kembali ke Laporan Penjualan
                </a>
                {{-- Tombol Cetak Struk (Nanti diimplementasikan jika diperlukan) --}}
                {{-- <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2m-1-4l4-4m0 0l4 4m-4-4v7m6 2v4a2 2 0 01-2 2H3a2 2 0 01-2-2v-4m-1-4l4-4m0 0l4 4m-4-4v7"/>
                    </svg>
                    Cetak Struk
                </button> --}}
            </div>
        </div>
    </div>
</div>
@endsection