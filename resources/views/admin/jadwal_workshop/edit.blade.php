@extends('layouts.app')

@section('title', 'Edit Jadwal Workshop')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Edit Jadwal Workshop --}}
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Jadwal Workshop</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">
                    untuk Paket: <span class="font-semibold text-teal-700">{{ $jadwalWorkshop->paketWorkshop->nama_paket ?? 'N/A' }}</span> pada Tanggal: <span class="font-semibold text-teal-700">{{ \Carbon\Carbon::parse($jadwalWorkshop->tanggal)->format('d M Y') }}</span>
                </p>
            </div>
        </div>

        {{-- Notifications --}}
        @if ($errors->any())
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
                                <strong>Oops!</strong> Ada beberapa masalah dengan input Anda.
                            </p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
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

        {{-- Main Content Card with Form --}}
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <form method="POST" action="{{ route('admin.jadwal_workshop.update', $jadwalWorkshop->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="paket_workshop_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Paket Workshop</label>
                    <select name="paket_workshop_id" id="paket_workshop_id"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('paket_workshop_id') border-red-500 @enderror"
                        required>
                        <option value="">-- Pilih Paket Workshop --</option>
                        @foreach ($paketWorkshops as $paket)
                            <option value="{{ $paket->id }}" {{ old('paket_workshop_id', $jadwalWorkshop->paket_workshop_id) == $paket->id ? 'selected' : '' }}>
                                {{ $paket->nama_paket }} (Rp {{ number_format($paket->harga_individu, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('paket_workshop_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Workshop</label>
                        <input type="date" name="tanggal" id="tanggal"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('tanggal') border-red-500 @enderror"
                            value="{{ old('tanggal', \Carbon\Carbon::parse($jadwalWorkshop->tanggal)->format('Y-m-d')) }}" required>
                        @error('tanggal')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_peserta" class="block text-sm font-medium text-gray-700 mb-1">Maksimal Peserta</label>
                        <input type="number" name="max_peserta" id="max_peserta"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('max_peserta') border-red-500 @enderror"
                            value="{{ old('max_peserta', $jadwalWorkshop->max_peserta) }}" required min="1" max="100" placeholder="Contoh: 20">
                        @error('max_peserta')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('jam_mulai') border-red-500 @enderror"
                            value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwalWorkshop->jam_mulai)->format('H:i')) }}" required>
                        @error('jam_mulai')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('jam_selesai') border-red-500 @enderror"
                            value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwalWorkshop->jam_selesai)->format('H:i')) }}" required>
                        @error('jam_selesai')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Jadwal</label>
                    <select name="status" id="status"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('status') border-red-500 @enderror"
                        required>
                        <option value="available" {{ old('status', $jadwalWorkshop->status) == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="unavailable" {{ old('status', $jadwalWorkshop->status) == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                        @if ($jadwalWorkshop->status === 'full')
                            <option value="full" {{ old('status', $jadwalWorkshop->status) == 'full' ? 'selected' : '' }}>Penuh</option>
                        @endif
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-8">
                    <a href="{{ route('admin.jadwal_workshop.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 mr-4">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Update Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection