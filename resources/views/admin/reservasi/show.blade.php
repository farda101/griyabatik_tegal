@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Detail/Mata untuk Reservasi --}}
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Detail Reservasi</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Untuk Nomor Reservasi: <span class="font-semibold text-purple-700">{{ $reservasi->nomor_reservasi }}</span></p>
            </div>
        </div>

        {{-- Main Content Card with Details --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            {{-- Bagian Status Pembayaran --}}
            <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm text-center">
                <p class="text-lg font-medium text-gray-800 mb-2">Status Pembayaran:</p>
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
                <span class="inline-flex items-center px-4 py-2 rounded-full text-xl font-bold leading-5 {{ $statusClass }}">
                    {{ $statusText }}
                </span>
                @if($reservasi->status_pembayaran === 'paid' && $reservasi->paid_at)
                    <p class="text-sm text-gray-500 mt-2">Dibayar pada: {{ \Carbon\Carbon::parse($reservasi->paid_at)->format('d M Y H:i') }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {{-- Bagian Detail Workshop --}}
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-indigo-200 flex items-center">
                        <svg class="h-6 w-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7v3m0-3h3m-3 0h-3m-3 7v3m0-3h3"/>
                        </svg>
                        Informasi Workshop
                    </h3>
                    <dl class="divide-y divide-gray-200 text-gray-700">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">ID Reservasi</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold">{{ $reservasi->id }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Nomor Reservasi</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-semibold text-gray-800">{{ $reservasi->nomor_reservasi }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Paket Workshop</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $reservasi->jadwalWorkshop->paketWorkshop->nama_paket ?? 'N/A' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Tanggal Workshop</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->tanggal)->format('d M Y') ?? 'N/A' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Waktu Workshop</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_mulai)->format('H:i') ?? 'N/A' }} - {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_selesai)->format('H:i') ?? 'N/A' }}
                            </dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Jenis Peserta</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ ucfirst($reservasi->jenis_peserta) }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Jumlah Peserta</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $reservasi->jumlah_peserta }} orang</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Total Harga</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0 font-bold text-lg text-green-600">
                                Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Bagian Detail Pemesan & File --}}
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 shadow-sm">
                    <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-pink-200 flex items-center">
                        <svg class="h-6 w-6 text-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Data Pemesan
                    </h3>
                    <dl class="divide-y divide-gray-200 text-gray-700">
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Nama Pemesan</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $reservasi->nama_pemesan }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Email Pemesan</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $reservasi->email_pemesan }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Telepon Pemesan</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $reservasi->telepon_pemesan }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Alamat Pemesan</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $reservasi->alamat_pemesan ?? '-' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">File Permohonan</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                @if($reservasi->file_permohonan)
                                    <a href="{{ route('admin.reservasi.download', $reservasi->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-900 underline">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Unduh File
                                    </a>
                                @else
                                    - Tidak ada file -
                                @endif
                            </dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Midtrans Transaction ID</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ $reservasi->midtrans_transaction_id ?? '-' }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Pengingat Dikirim?</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $reservasi->reminder_sent ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $reservasi->reminder_sent ? 'Ya' : 'Tidak' }}
                                </span>
                            </dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Dibuat Pada</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($reservasi->created_at)->format('d M Y H:i') }}</dd>
                        </div>
                        <div class="py-3 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium">Terakhir Diperbarui</dt>
                            <dd class="mt-1 text-sm sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($reservasi->updated_at)->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.reservasi.index') }}"
                   class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('admin.reservasi.edit', $reservasi->id) }}"
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Reservasi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection