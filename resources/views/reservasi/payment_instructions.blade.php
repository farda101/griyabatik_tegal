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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Mohon segera lakukan pembayaran untuk konfirmasi.
                    </p>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h3 class="font-semibold text-xl text-gray-800 mb-5 flex items-center">
                        <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Detail Pembayaran
                    </h3>
                    <dl class="divide-y divide-gray-200 bg-gray-50 rounded-lg p-5">
                        <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-base font-medium leading-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Batas Waktu Pembayaran
                            </dt>
                            <dd class="mt-1 text-base leading-6 text-red-600 font-semibold sm:col-span-2 sm:mt-0">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                    <p class="text-red-800 font-medium">Harap lakukan pembayaran sebelum:</p>
                                    <p class="text-lg font-bold text-red-700 mt-1">
                                        {{ $reservasi->payment_deadline->format('d M Y, H:i') }} WIB
                                    </p>
                                    <p class="text-sm text-red-600 mt-2">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                        </svg>
                                        Jika tidak dibayar dalam 24 jam, reservasi akan otomatis dibatalkan.
                                    </p>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-8 text-center pt-6 border-t border-gray-200">
                    @csrf
                    <button id="pay-button"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.01V4a2 2 0 012-2h4a2 2 0 012 2v2M4 16h-.01L4 16m2.003 6.002H18A2 2 0 0020 20V8a2 2 0 00-2-2h-2m-3.997 0h-.002a9.97 9.97 0 00-2.868 1.488l-2.003 2.003a2 2 0 00-.707 1.414V14a2 2 0 002 2h8a2 2 0 002-2v-4a2 2 0 00-2-2h-2V6z" />
                        </svg>
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{config('midtrans.client_key')}}"></script>
<script type="text/javascript">
    async function handlePaymentSuccess(result) {
        const token = "{{ csrf_token() }}"
        const res = await fetch(
            "{{ route('reservasi.handlePaymentSuccess', $reservasi) }}",
            {
                method: "POST",
                body: JSON.stringify({ data: result, _token: token}),
                headers: { 'Content-Type': 'application/json' },

            }
            );
        const t = await res.json();
        if (t.redirect) {
            window.location.href = t.redirect 
        }
        
    }
    document.getElementById('pay-button').onclick = function() {
        // SnapToken acquired from previous step
        snap.pay('<?= $snapToken ?>', {
            // Optional
            onSuccess: async function(result) {
                await handlePaymentSuccess(result)
                /* You may add your own js here, this is just example */
                // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onPending: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result) {
                /* You may add your own js here, this is just example */
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    };
</script>
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