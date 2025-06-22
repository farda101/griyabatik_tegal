@extends('layouts.public')

@section('title', 'Detail Status Reservasi')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-teal-600 to-blue-600 p-8 text-white text-center">
                <h2 class="font-bold text-3xl mb-2">
                    Detail Status Reservasi Anda
                </h2>
                <p class="text-teal-100 text-lg">Informasi lengkap reservasi workshop batik Anda.</p>
            </div>

            <div class="p-8">
                <div class="mb-8 text-center bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <p class="text-lg text-gray-700 mb-2">Nomor Reservasi:</p>
                    <p class="text-5xl sm:text-6xl font-extrabold text-indigo-700 my-4 tracking-wide">{{ $reservasi->nomor_reservasi }}</p>
                    <p class="text-sm text-gray-600 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi ini adalah detail reservasi Anda.
                    </p>
                </div>

                {{-- Status Pembayaran Badge --}}
                <div class="mb-8 text-center">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-base font-semibold leading-5
                        @if($reservasi->status_pembayaran === 'paid') bg-green-100 text-green-800
                        @elseif($reservasi->status_pembayaran === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($reservasi->status_pembayaran === 'failed' || $reservasi->status_pembayaran === 'expired') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            @if($reservasi->status_pembayaran === 'paid')
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            @elseif($reservasi->status_pembayaran === 'pending')
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.3 2.647-1.3 3.412 0l5.448 9.207A1.999 1.999 0 0116.596 15H3.404a1.999 1.999 0 01-1.631-2.694l5.448-9.207zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            @else
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            @endif
                        </svg>
                        Status Pembayaran: <span class="font-bold ml-1">{{ ucfirst($reservasi->status_pembayaran) }}</span>
                    </span>

                    @if($reservasi->status_pembayaran === 'pending')
                        <p class="text-base text-gray-700 mt-4 leading-relaxed">
                            Reservasi Anda telah berhasil diajukan! Mohon segera lakukan pembayaran untuk mengkonfirmasi tempat Anda di workshop.
                        </p>
                        <a href="{{ route('reservasi.payment_instructions', ['reservasi' => $reservasi->id]) }}"
                           class="mt-6 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-600 transition duration-300 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10M10 20H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v2M5 8h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2z"/>
                            </svg>
                            Lihat Instruksi Pembayaran
                        </a>
                    @elseif($reservasi->status_pembayaran === 'paid')
                        <p class="text-base text-gray-700 mt-4 leading-relaxed">
                            Pembayaran Anda telah **dikonfirmasi**! Kami menantikan kedatangan Anda di workshop.
                        </p>
                        <p class="text-sm text-gray-500 mt-2">Dibayar pada: {{ $reservasi->paid_at ? \Carbon\Carbon::parse($reservasi->paid_at)->format('d F Y H:i') : '-' }} WIB</p>
                        <div class="mt-6 flex flex-wrap justify-center gap-4">
                            <a href="#" class="inline-flex items-center px-6 py-3 bg-purple-500 text-white font-semibold rounded-xl hover:bg-purple-600 transition duration-300 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13a6.002 6.002 0 00-4.243 1.757C5.353 8.369 4 10.732 4 13.5a6.002 6.002 0 004.243 4.243m0-8.486c1.757 1.757 4.243 1.757 6 0m-8.486 0L19 13.5a6.002 6.002 0 00-4.243-4.243m0 8.486c-1.757 1.757-4.243 1.757-6 0m8.486 0L5 13.5a6.002 6.002 0 014.243-4.243"/>
                                </svg>
                                Tambah ke Kalender
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-500 text-white font-semibold rounded-xl hover:bg-green-600 transition duration-300 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 21.656l1.796-6.143c-.768-1.077-1.189-2.316-1.189-3.593 0-6.182 5.011-11.192 11.192-11.192 3.067 0 5.962 1.206 8.136 3.38s3.38 5.069 3.38 8.136c0 6.18-5.011 11.192-11.192 11.192-1.277 0-2.516-.421-3.593-1.189l-6.143 1.796zm17.973-10.735c0-4.945-4.004-8.949-8.949-8.949s-8.949 4.004-8.949 8.949c0 .983.159 1.956.467 2.883l-1.042 3.565 3.565-1.042c.927.308 1.9.467 2.883.467 4.945 0 8.949-4.004 8.949-8.949zM16.144 14.887a.97.97 0 01-.645-.258c-.287-.229-1.666-.82-1.923-.918-.258-.097-.446-.145-.645.145-.199.29-1.923 2.339-2.348 2.637-.425.29-2.032.748-3.896-.918-.732-.656-1.839-1.989-2.585-3.218-.748-1.229-.072-1.9-.072-2.191 0-.29.176-.435.395-.654.219-.219.467-.565.645-.845.176-.28.088-.523-.036-.722-.12-.199-.645-1.554-.888-2.12-.243-.565-.486-.49-.645-.49-.168 0-.356-.007-.544-.007-.22-.007-.577.08-1.144.577-.565.494-2.12 2.062-2.12 5.025 0 2.963 2.164 5.926 2.472 6.347.308.421 4.298 6.577 10.457 6.577 2.585 0 3.895-.888 4.636-1.258.748-.37 1.488-1.554 1.711-2.909.229-1.355.229-2.433.16-2.586-.072-.153-.27-.225-.565-.378z"/>
                                </svg>
                                Chat dengan Admin
                            </a>
                        </div>
                    @elseif($reservasi->status_pembayaran === 'failed' || $reservasi->status_pembayaran === 'expired')
                        <p class="text-base text-gray-700 mt-4 leading-relaxed">
                            Pembayaran Anda **gagal** atau telah **kadaluarsa**. Silakan coba membuat reservasi baru atau hubungi admin.
                        </p>
                        <div class="mt-6 flex flex-wrap justify-center gap-4">
                            <a href="{{ route('reservasi.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition duration-300 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Buat Reservasi Baru
                            </a>
                            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center px-6 py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition duration-300 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 21.656l1.796-6.143c-.768-1.077-1.189-2.316-1.189-3.593 0-6.182 5.011-11.192 11.192-11.192 3.067 0 5.962 1.206 8.136 3.38s3.38 5.069 3.38 8.136c0 6.18-5.011 11.192-11.192 11.192-1.277 0-2.516-.421-3.593-1.189l-6.143 1.796zm17.973-10.735c0-4.945-4.004-8.949-8.949-8.949s-8.949 4.004-8.949 8.949c0 .983.159 1.956.467 2.883l-1.042 3.565 3.565-1.042c.927.308 1.9.467 2.883.467 4.945 0 8.949-4.004 8.949-8.949zM16.144 14.887a.97.97 0 01-.645-.258c-.287-.229-1.666-.82-1.923-.918-.258-.097-.446-.145-.645.145-.199.29-1.923 2.339-2.348 2.637-.425.29-2.032.748-3.896-.918-.732-.656-1.839-1.989-2.585-3.218-.748-1.229-.072-1.9-.072-2.191 0-.29.176-.435.395-.654.219-.219.467-.565.645-.845.176-.28.088-.523-.036-.722-.12-.199-.645-1.554-.888-2.12-.243-.565-.486-.49-.645-.49-.168 0-.356-.007-.544-.007-.22-.007-.577.08-1.144.577-.565.494-2.12 2.062-2.12 5.025 0 2.963 2.164 5.926 2.472 6.347.308.421 4.298 6.577 10.457 6.577 2.585 0 3.895-.888 4.636-1.258.748-.37 1.488-1.554 1.711-2.909.229-1.355.229-2.433.16-2.586-.072-.153-.27-.225-.565-.378z"/>
                                </svg>
                                Hubungi Admin
                            </a>
                        </div>
                    @else
                        <p class="text-base text-gray-700 mt-4 leading-relaxed">
                            Status pembayaran tidak dikenali atau belum ada data.
                        </p>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="font-semibold text-xl text-gray-800 mb-5 flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        Detail Reservasi
                    </h3>
                    <dl class="divide-y divide-gray-200 bg-gray-50 rounded-lg p-5">
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Paket Workshop
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">
                                {{ $reservasi->jadwalWorkshop->paketWorkshop->nama_paket ?? 'N/A' }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Workshop
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">
                                {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->tanggal)->format('d F Y') }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Waktu Workshop
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">
                                {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_selesai)->format('H:i') }} WIB
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V8a2 2 0 00-2-2h-2M15 4a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0h.01M9 6h.01M9 16H9.01M17 16H17.01M6 16h-.01M9 20h.01M17 20h.01M6 20h-.01M12 12h.01"/>
                                </svg>
                                Jenis Peserta
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">
                                {{ ucfirst($reservasi->jenis_peserta) }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h2a2 2 0 002-2V8a2 2 0 00-2-2h-2M15 4a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0h.01M9 6h.01M9 16H9.01M17 16H17.01M6 16h-.01M9 20h.01M17 20h.01M6 20h-.01M12 12h.01"/>
                                </svg>
                                Jumlah Peserta
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0 font-semibold">
                                {{ $reservasi->jumlah_peserta }} orang
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Total Harga
                            </dt>
                            <dd class="mt-1 text-2xl leading-6 text-indigo-700 sm:col-span-2 sm:mt-0 font-extrabold">
                                Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="font-semibold text-xl text-gray-800 mb-5 flex items-center">
                        <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Data Pemesan
                    </h3>
                    <dl class="divide-y divide-gray-200 bg-gray-50 rounded-lg p-5">
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM2 13a2 2 0 114 0 2 2 0 01-4 0z"/>
                                </svg>
                                Nama Pemesan
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $reservasi->nama_pemesan }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-9 13v-5m0 0a3 3 0 100-6 3 3 0 000 6zM5 19v-2M19 19v-2"/>
                                </svg>
                                Email Pemesan
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $reservasi->email_pemesan }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Telepon Pemesan
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $reservasi->telepon_pemesan }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Alamat Pemesan
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                {{ $reservasi->alamat_pemesan ?? '-' }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a2 2 0 00-2.828-2.828l-6.414 6.414a2 2 0 01-2.828 0L7 13.172V17h4l-3 3-2 2H4a2 2 0 01-2-2V4a2 2 0 012-2h4l2 2 3-3V7a2 2 0 012-2h4a2 2 0 012 2z"/>
                                </svg>
                                File Permohonan
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                @if($reservasi->file_permohonan)
                                    <a href="{{ asset('storage/' . $reservasi->file_permohonan) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0l-7 7M14 4v6"/>
                                        </svg>
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-gray-500">- Tidak Ada -</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-8 text-center pt-6 border-t border-gray-200">
                    <a href="{{ route('reservasi.status.check.form') }}"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-700 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-gray-600 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Cari Reservasi Lain
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection