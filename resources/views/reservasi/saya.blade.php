@extends('layouts.public')

@section('title', 'Reservasi Saya')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Reservasi Saya</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($reservasis->count() > 0)
        <div class="overflow-x-auto bg-white shadow rounded-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left">Nomor Reservasi</th>
                        <th class="py-3 px-4 text-left">Tanggal & Jam</th>
                        <th class="py-3 px-4 text-left">Paket Workshop</th>
                        <th class="py-3 px-4 text-left">Jumlah Peserta</th>
                        <th class="py-3 px-4 text-left">Status Pembayaran</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservasis as $reservasi)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $reservasi->nomor_reservasi }}</td>
                            <td class="py-2 px-4">
                                {{ optional($reservasi->jadwalWorkshop)->tanggal ? \Carbon\Carbon::parse($reservasi->jadwalWorkshop->tanggal)->format('d M Y') : '-' }}
                                <br>
                                {{ optional($reservasi->jadwalWorkshop)->jam_mulai ? \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_mulai)->format('H:i') : '-' }}
                                -
                                {{ optional($reservasi->jadwalWorkshop)->jam_selesai ? \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_selesai)->format('H:i') : '-' }}
                            </td>
                            <td class="py-2 px-4">
                                {{ optional($reservasi->jadwalWorkshop->paketWorkshop)->nama_paket ?? '-' }}
                            </td>
                            <td class="py-2 px-4">{{ $reservasi->jumlah_peserta }}</td>
                            <td class="py-2 px-4">
                                @if($reservasi->status_pembayaran == 'paid')
                                    <span class="inline-block px-2 py-1 bg-green-500 text-white rounded text-xs">Lunas</span>
                                @elseif($reservasi->status_pembayaran == 'pending')
                                    <span class="inline-block px-2 py-1 bg-yellow-400 text-gray-800 rounded text-xs">Menunggu</span>
                                @elseif($reservasi->status_pembayaran == 'failed')
                                    <span class="inline-block px-2 py-1 bg-red-500 text-white rounded text-xs">Gagal</span>
                                @elseif($reservasi->status_pembayaran == 'expired')
                                    <span class="inline-block px-2 py-1 bg-gray-400 text-white rounded text-xs">Kedaluwarsa</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">
                                {{-- Jika ingin buat halaman detail, tambahkan route di sini --}}
                                {{-- <a href="{{ route('reservasi.detail', $reservasi->id) }}" class="text-blue-600 underline">Detail</a> --}}
                                @if($reservasi->status_pembayaran == 'pending')
                                    <span class="text-gray-400 text-xs">Menunggu Pembayaran</span>
                                @else
                                    <span class="text-gray-500 text-xs">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4">
                {{ $reservasis->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-10 text-gray-500">
            Anda belum memiliki reservasi workshop.
        </div>
    @endif
</div>
@endsection
