@extends('layouts.app')

@section('title', 'Edit Reservasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-100 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center">
                    {{-- Ikon Edit Reservasi --}}
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-500 p-2 rounded-lg mr-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Reservasi</h1>
                </div>
                <p class="text-gray-600 mt-2 ml-12">Untuk Nomor Reservasi: <span class="font-semibold text-purple-700">{{ $reservasi->nomor_reservasi }}</span></p>
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
            <form method="POST" action="{{ route('admin.reservasi.update', $reservasi->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h3 class="font-bold text-xl text-gray-900 mb-4 pb-2 border-b-2 border-indigo-200 flex items-center">
                    <svg class="h-6 w-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7v3m0-3h3m-3 0h-3m-3 7v3m0-3h3"/>
                    </svg>
                    Detail Workshop
                </h3>

                <div class="mb-6">
                    <label for="jadwal_workshop_display" class="block text-sm font-medium text-gray-700 mb-1">Jadwal Workshop</label>
                    <input type="hidden" name="jadwal_workshop_id" value="{{ $reservasi->jadwal_workshop_id }}">
                    <input type="text" id="jadwal_workshop_display"
                        class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                        value="{{ $reservasi->jadwalWorkshop->paketWorkshop->nama_paket ?? 'N/A' }} - {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->tanggal)->format('d M Y') ?? 'N/A' }} ({{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_mulai)->format('H:i') ?? 'N/A' }} - {{ \Carbon\Carbon::parse($reservasi->jadwalWorkshop->jam_selesai)->format('H:i') ?? 'N/A' }})"
                        readonly>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jenis_peserta" class="block text-sm font-medium text-gray-700 mb-1">Jenis Peserta</label>
                        <input type="hidden" name="jenis_peserta" value="{{ $reservasi->jenis_peserta }}">
                        <input type="text" id="jenis_peserta_display"
                            class="block w-full rounded-lg bg-gray-100 border-gray-300 shadow-sm sm:text-sm p-2.5 cursor-not-allowed"
                            value="{{ ucfirst($reservasi->jenis_peserta) }}" readonly>
                    </div>

                    <div>
                        <label for="jumlah_peserta" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Peserta</label>
                        <input type="number" name="jumlah_peserta" id="jumlah_peserta"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('jumlah_peserta') border-red-500 @enderror"
                            value="{{ old('jumlah_peserta', $reservasi->jumlah_peserta) }}" required min="1" placeholder="Contoh: 1">
                        @error('jumlah_peserta')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <h3 class="font-bold text-xl text-gray-900 mb-4 mt-8 pb-2 border-b-2 border-pink-200 flex items-center">
                    <svg class="h-6 w-6 text-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Data Pemesan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" id="nama_pemesan"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('nama_pemesan') border-red-500 @enderror"
                            value="{{ old('nama_pemesan', $reservasi->nama_pemesan) }}" required maxlength="255" placeholder="Nama lengkap pemesan">
                        @error('nama_pemesan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Email Pemesan</label>
                        <input type="email" name="email_pemesan" id="email_pemesan"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('email_pemesan') border-red-500 @enderror"
                            value="{{ old('email_pemesan', $reservasi->email_pemesan) }}" required maxlength="255" placeholder="Email aktif pemesan">
                        @error('email_pemesan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label for="telepon_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Telepon Pemesan</label>
                        <input type="text" name="telepon_pemesan" id="telepon_pemesan"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('telepon_pemesan') border-red-500 @enderror"
                            value="{{ old('telepon_pemesan', $reservasi->telepon_pemesan) }}" required maxlength="20" placeholder="Contoh: 081234567890">
                        @error('telepon_pemesan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_harga" class="block text-sm font-medium text-gray-700 mb-1">Total Harga</label>
                        <input type="number" name="total_harga" id="total_harga"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                                @error('total_harga') border-red-500 @enderror"
                            value="{{ old('total_harga', $reservasi->total_harga) }}" required min="0" step="0.01" placeholder="Contoh: 100000">
                        @error('total_harga')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="alamat_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pemesan (Opsional)</label>
                    <textarea name="alamat_pemesan" id="alamat_pemesan" rows="3"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('alamat_pemesan') border-red-500 @enderror"
                        maxlength="500" placeholder="Alamat lengkap pemesan">{{ old('alamat_pemesan', $reservasi->alamat_pemesan) }}</textarea>
                    @error('alamat_pemesan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <h3 class="font-bold text-xl text-gray-900 mb-4 mt-8 pb-2 border-b-2 border-green-200 flex items-center">
                    <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status & Dokumen
                </h3>

                <div class="mb-6">
                    <label for="status_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran"
                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2.5
                            @error('status_pembayaran') border-red-500 @enderror"
                        required>
                        <option value="pending" {{ old('status_pembayaran', $reservasi->status_pembayaran) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('status_pembayaran', $reservasi->status_pembayaran) == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="failed" {{ old('status_pembayaran', $reservasi->status_pembayaran) == 'failed' ? 'selected' : '' }}>Gagal</option>
                        <option value="expired" {{ old('status_pembayaran', $reservasi->status_pembayaran) == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                    </select>
                    @error('status_pembayaran')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="file_permohonan" class="block text-sm font-medium text-gray-700 mb-1">File Permohonan (PDF/DOC/DOCX, Max 2MB, Opsional)</label>
                    @if($reservasi->file_permohonan)
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <span class="mr-2">File saat ini:</span>
                            <a href="{{ route('admin.reservasi.download', $reservasi->id) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:text-blue-900 underline">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Lihat File
                            </a>
                            <label for="file_permohonan_action_delete" class="ml-4 inline-flex items-center text-red-600 cursor-pointer">
                                <input type="checkbox" name="file_permohonan_action" id="file_permohonan_action_delete" value="delete" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                <span class="ml-1 text-sm">Hapus File</span>
                            </label>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 mb-2">Tidak ada file permohonan saat ini.</p>
                    @endif
                    <input type="file" name="file_permohonan" id="file_permohonan"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                                @error('file_permohonan') border-red-500 @enderror">
                    @error('file_permohonan')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input type="hidden" name="reminder_sent" value="0">
                    <input type="checkbox" name="reminder_sent" id="reminder_sent" value="1"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5"
                        {{ old('reminder_sent', $reservasi->reminder_sent) ? 'checked' : '' }}>
                    <label for="reminder_sent" class="ml-2 block text-base font-medium text-gray-800">Pengingat Dikirim</label>
                    @error('reminder_sent')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-8">
                    <a href="{{ route('admin.reservasi.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg transform hover:scale-105 transition duration-200 mr-4">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Update Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection