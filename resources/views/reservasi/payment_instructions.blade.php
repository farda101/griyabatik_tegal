@extends('layouts.public')

@section('title', 'Instruksi Pembayaran')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 p-8 text-white text-center">
                <h2 class="font-bold text-3xl mb-2">
                    Instruksi Pembayaran Reservasi
                </h2>
                <p class="text-green-100 text-lg">Lakukan pembayaran untuk mengkonfirmasi reservasi Anda!</p>
            </div>

            <div class="p-8">
                {{-- Notifikasi --}}
                @if (Session::has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ Session::get('success') }}</span>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ Session::get('error') }}</span>
                    </div>
                @endif

                <div class="text-center mb-8 bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <p class="text-lg text-gray-700 mb-2">Reservasi Anda dengan nomor:</p>
                    <p class="text-5xl sm:text-6xl font-extrabold text-blue-700 my-4 tracking-wide">{{ $reservasi->nomor_reservasi }}</p>
                    <p class="text-lg text-gray-700">Telah berhasil diajukan!</p>
                    <p class="text-sm text-blue-600 mt-3 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Mohon segera lakukan pembayaran untuk konfirmasi.
                    </p>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="font-semibold text-xl text-gray-800 mb-5 flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Detail Pembayaran
                    </h3>
                    <dl class="divide-y divide-gray-200 bg-gray-50 rounded-lg p-5">
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Jumlah yang Harus Dibayar
                            </dt>
                            <dd class="mt-1 text-2xl leading-6 text-indigo-700 font-extrabold sm:col-span-2 sm:mt-0">
                                Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Batas Waktu Pembayaran
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-red-600 font-semibold sm:col-span-2 sm:mt-0">
                                Harap lakukan pembayaran dalam waktu **24 jam** dari sekarang.
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="font-semibold text-xl text-gray-800 mb-5 flex items-center">
                        <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h10M10 20H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v2M5 8h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2z"/>
                        </svg>
                        Instruksi Transfer Bank
                    </h3>
                    <p class="text-gray-700 mb-5 leading-relaxed">Silakan transfer sejumlah **<span class="font-bold text-indigo-700">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>** ke rekening berikut:</p>

                    <div class="bg-gray-100 rounded-lg p-6 mb-6 shadow-inner">
                        <ul class="space-y-3 text-gray-800 text-base">
                            <li class="flex items-center">
                                <strong class="w-32">Nama Bank:</strong>
                                <span class="ml-2 font-semibold">Bank BCA</span>
                            </li>
                            <li class="flex items-center">
                                <strong class="w-32">Nomor Rekening:</strong>
                                <span class="ml-2 font-semibold text-purple-700 text-lg">0471669791</span>
                                <button onclick="copyToClipboard('1234567890123456')" class="ml-3 text-sm text-blue-500 hover:text-blue-700 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-2m-6-6L17 5l4 4-6 6H8l-.5 4.5 4.5-.5V8z"/>
                                    </svg>
                                    Salin
                                </button>
                            </li>
                            <li class="flex items-center">
                                <strong class="w-32">Atas Nama:</strong>
                                <span class="ml-2 font-semibold">PT. Griya Batik Tegal</span>
                            </li>
                        </ul>
                    </div>

                    <p class="text-gray-700 mt-6 leading-relaxed bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <span class="font-bold">Penting:</span> Setelah melakukan transfer, harap **hubungi admin kami melalui WhatsApp atau email** untuk konfirmasi pembayaran. Sertakan **Nomor Reservasi Anda** ({{ $reservasi->nomor_reservasi }}) dalam pesan konfirmasi.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mt-8 justify-center">
                        <a href="https://wa.me/6282313732746" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-green-500 border border-transparent rounded-xl font-semibold text-white hover:bg-green-600 transition duration-300 shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 21.656l1.796-6.143c-.768-1.077-1.189-2.316-1.189-3.593 0-6.182 5.011-11.192 11.192-11.192 3.067 0 5.962 1.206 8.136 3.38s3.38 5.069 3.38 8.136c0 6.18-5.011 11.192-11.192 11.192-1.277 0-2.516-.421-3.593-1.189l-6.143 1.796zm17.973-10.735c0-4.945-4.004-8.949-8.949-8.949s-8.949 4.004-8.949 8.949c0 .983.159 1.956.467 2.883l-1.042 3.565 3.565-1.042c.927.308 1.9.467 2.883.467 4.945 0 8.949-4.004 8.949-8.949zM16.144 14.887a.97.97 0 01-.645-.258c-.287-.229-1.666-.82-1.923-.918-.258-.097-.446-.145-.645.145-.199.29-1.923 2.339-2.348 2.637-.425.29-2.032.748-3.896-.918-.732-.656-1.839-1.989-2.585-3.218-.748-1.229-.072-1.9-.072-2.191 0-.29.176-.435.395-.654.219-.219.467-.565.645-.845.176-.28.088-.523-.036-.722-.12-.199-.645-1.554-.888-2.12-.243-.565-.486-.49-.645-.49-.168 0-.356-.007-.544-.007-.22-.007-.577.08-1.144.577-.565.494-2.12 2.062-2.12 5.025 0 2.963 2.164 5.926 2.472 6.347.308.421 4.298 6.577 10.457 6.577 2.585 0 3.895-.888 4.636-1.258.748-.37 1.488-1.554 1.711-2.909.229-1.355.229-2.433.16-2.586-.072-.153-.27-.225-.565-.378z"/>
                            </svg>
                            Hubungi Admin via WhatsApp
                        </a>
                        <a href="mailto:admin@batiktegalan.com" class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 border border-transparent rounded-xl font-semibold text-white hover:bg-blue-600 transition duration-300 shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H8a2 2 0 00-1.997 1.884zM18 8.118l4 2V14l-4 2-4-2V10.118l4-2zM2 8.118L6 10.118V14l-4-2V8.118zM18 16V18a2 2 0 01-2 2H8a2 2 0 01-2-2v-2l-4-2V6a2 2 0 012-2h12a2 2 0 012 2v10z"/>
                            </svg>
                            Kirim Email ke Admin
                        </a>
                    </div>
                </div>

                <div class="mt-8 text-center pt-6 border-t border-gray-200">
                    <a href="{{ route('reservasi.status.check.form') }}"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.01V4a2 2 0 012-2h4a2 2 0 012 2v2M4 16h-.01L4 16m2.003 6.002H18A2 2 0 0020 20V8a2 2 0 00-2-2h-2m-3.997 0h-.002a9.97 9.97 0 00-2.868 1.488l-2.003 2.003a2 2 0 00-.707 1.414V14a2 2 0 002 2h8a2 2 0 002-2v-4a2 2 0 00-2-2h-2V6z"/>
                        </svg>
                        Cek Status Reservasi Anda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Nomor rekening berhasil disalin!');
        }, function(err) {
            console.error('Gagal menyalin teks: ', err);
        });
    }
</script>
@endsection