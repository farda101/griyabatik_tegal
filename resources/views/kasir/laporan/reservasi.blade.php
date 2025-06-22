@extends('layouts.app')

@section('title', 'Laporan Reservasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Laporan Reservasi --}}
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Laporan Reservasi</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Lihat dan filter catatan reservasi workshop.</p>
            </div>
        </div>

        {{-- Main Content Card (untuk Filter dan Tabel) --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            {{-- Filter dan Tombol Export --}}
            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4">
                <form action="{{ route('kasir.laporan.reservasi.index') }}" method="GET" class="flex flex-col sm:flex-row items-end sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jadwal:</label>
                        <input type="date" name="date" id="date" value="{{ $filterDate }}"
                            class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm p-2.5">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran:</label>
                        <select name="status" id="status" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm p-2.5">
                            <option value="all" {{ $filterStatus == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="pending" {{ $filterStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $filterStatus == 'paid' ? 'selected' : '' }}>Lunas</option>
                            <option value="failed" {{ $filterStatus == 'failed' ? 'selected' : '' }}>Gagal</option>
                            <option value="expired" {{ $filterStatus == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-xl font-semibold text-white shadow-md hover:bg-blue-700 focus:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                        Filter
                    </button>
                </form>

                {{-- Tombol Export Excel (jika nanti diimplementasikan untuk laporan reservasi) --}}
                {{-- <a href="{{ route('kasir.laporan.reservasi.export', ['date' => $filterDate, 'status' => $filterStatus]) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </a> --}}
            </div>

            <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-lg">
                                Nomor Reservasi
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Nama Pemesan
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Tanggal Workshop
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Paket Workshop
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Jumlah Peserta
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-lg">
                                Status Pembayaran
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($reservasis as $reservasi)
                            <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $reservasi->nomor_reservasi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reservasi->nama_pemesan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->tanggal)->format('d M Y') ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reservasi->jadwalWorkshop->paketWorkshop->nama_paket ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reservasi->jumlah_peserta }} <span class="text-gray-500">orang</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $statusClass = '';
                                        $statusText = ucfirst($reservasi->status_pembayaran);
                                        if ($reservasi->status_pembayaran === 'paid') {
                                            $statusClass = 'bg-green-100 text-green-800 border border-green-200';
                                            $statusText = 'Lunas';
                                        } elseif ($reservasi->status_pembayaran === 'pending') {
                                            $statusClass = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                            $statusText = 'Pending';
                                        } elseif ($reservasi->status_pembayaran === 'failed' || $reservasi->status_pembayaran === 'expired') {
                                            $statusClass = 'bg-red-100 text-red-800 border border-red-200';
                                        } else {
                                            $statusClass = 'bg-gray-100 text-gray-800 border border-gray-200';
                                        }
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada reservasi untuk tanggal dan status ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $reservasis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection