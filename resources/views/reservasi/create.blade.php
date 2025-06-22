@extends('layouts.public')

@section('title', 'Formulir Reservasi Workshop Batik')

@section('content')
<div class="bg-gradient-to-br from-gray-50 via-white to-indigo-50 min-h-screen pt-16 pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 text-white text-center">
                <h2 class="font-bold text-3xl mb-2">
                    Daftar Workshop Batik Tegalan
                </h2>
                <p class="text-indigo-100 text-lg">Isi formulir di bawah untuk reservasi tempat Anda!</p>
            </div>

            <div class="p-8">
                {{-- Notifikasi Error (jika ada kesalahan validasi) --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Oops! Ada masalah:</strong>
                        <ul class="mt-3 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- Notifikasi Error dari Session --}}
                @if (Session::has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ Session::get('error') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('reservasi.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-xl text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                Detail Workshop
                            </h3>

                            <div class="mb-5">
                                <label for="jadwal_workshop_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Jadwal Workshop <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="jadwal_workshop_id" id="jadwal_workshop_id"
                                        class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-base transition duration-150 ease-in-out
                                        @error('jadwal_workshop_id') border-red-500 @enderror"
                                        required>
                                        <option value="">-- Pilih Tanggal & Paket Workshop --</option>
                                        @forelse ($jadwalWorkshops as $jadwal)
                                            @if ($jadwal->paketWorkshop)
                                                <option value="{{ $jadwal->id }}"
                                                    data-harga-individu="{{ $jadwal->paketWorkshop->harga_individu }}"
                                                    data-harga-kelompok="{{ $jadwal->paketWorkshop->harga_kelompok }}"
                                                    {{ old('jadwal_workshop_id') == $jadwal->id ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                                    ({{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }})
                                                    - Paket: {{ $jadwal->paketWorkshop->nama_paket }} (Slot Tersisa: {{ $jadwal->slot_tersisa }})
                                                </option>
                                            @endif
                                        @empty
                                            <option value="" disabled>Tidak ada jadwal workshop yang tersedia saat ini.</option>
                                        @endforelse
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                @error('jadwal_workshop_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Peserta <span class="text-red-500">*</span></label>
                                <div class="flex items-center space-x-6">
                                    <label for="jenis_peserta_individu" class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="jenis_peserta" id="jenis_peserta_individu" value="individu"
                                            class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5"
                                            {{ old('jenis_peserta') == 'individu' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-base text-gray-800">Individu</span>
                                    </label>
                                    <label for="jenis_peserta_kelompok" class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="jenis_peserta" id="jenis_peserta_kelompok" value="kelompok"
                                            class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5"
                                            {{ old('jenis_peserta') == 'kelompok' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-base text-gray-800">Kelompok</span>
                                    </label>
                                </div>
                                @error('jenis_peserta')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="jumlah_peserta" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Peserta <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah_peserta" id="jumlah_peserta"
                                    class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-base transition duration-150 ease-in-out
                                    @error('jumlah_peserta') border-red-500 @enderror"
                                    value="{{ old('jumlah_peserta') }}" required min="1" placeholder="Masukkan jumlah peserta">
                                @error('jumlah_peserta')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold text-xl text-gray-800 mb-4 flex items-center">
                                <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Data Pemesan
                            </h3>

                            <div class="mb-5">
                                <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemesan <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_pemesan" id="nama_pemesan"
                                    class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-base transition duration-150 ease-in-out
                                    @error('nama_pemesan') border-red-500 @enderror"
                                    value="{{ old('nama_pemesan') }}" required maxlength="255" placeholder="Nama lengkap Anda">
                                @error('nama_pemesan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="email_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Email Pemesan <span class="text-red-500">*</span></label>
                                <input type="email" name="email_pemesan" id="email_pemesan"
                                    class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-base transition duration-150 ease-in-out
                                    @error('email_pemesan') border-red-500 @enderror"
                                    value="{{ old('email_pemesan') }}" required maxlength="255" placeholder="alamatemail@contoh.com">
                                @error('email_pemesan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="telepon_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Telepon Pemesan <span class="text-red-500">*</span></label>
                                <input type="text" name="telepon_pemesan" id="telepon_pemesan"
                                    class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-base transition duration-150 ease-in-out
                                    @error('telepon_pemesan') border-red-500 @enderror"
                                    value="{{ old('telepon_pemesan') }}" required maxlength="20" placeholder="Contoh: 08123456789">
                                @error('telepon_pemesan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="alamat_pemesan" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pemesan (Opsional)</label>
                                <textarea name="alamat_pemesan" id="alamat_pemesan" rows="3"
                                    class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-base transition duration-150 ease-in-out
                                    @error('alamat_pemesan') border-red-500 @enderror"
                                    maxlength="500" placeholder="Alamat lengkap Anda">{{ old('alamat_pemesan') }}</textarea>
                                @error('alamat_pemesan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="file_permohonan" class="block text-sm font-medium text-gray-700 mb-1">File Permohonan (PDF/DOC/DOCX, Max 2MB, Opsional)</label>
                                <input type="file" name="file_permohonan" id="file_permohonan"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer
                                    @error('file_permohonan') border-red-500 @enderror">
                                @error('file_permohonan')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h3 class="font-semibold text-xl text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Ringkasan Pembayaran
                        </h3>

                        <div class="mb-5">
                            <label for="total_harga_display" class="block text-sm font-medium text-gray-700 mb-1">Total Harga</label>
                            <input type="text" id="total_harga_display"
                                class="mt-1 block w-full py-3 px-4 bg-gray-100 border border-gray-300 rounded-lg shadow-sm sm:text-base cursor-not-allowed font-semibold text-gray-900"
                                value="Rp 0" readonly>
                            <input type="hidden" name="total_harga" id="total_harga_hidden" value="0">
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-semibold text-white uppercase tracking-wider hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 text-base shadow-lg">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Ajukan Reservasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jadwalSelect = document.getElementById('jadwal_workshop_id');
        const jenisPesertaRadios = document.querySelectorAll('input[name="jenis_peserta"]');
        const jumlahPesertaInput = document.getElementById('jumlah_peserta');
        const totalHargaDisplay = document.getElementById('total_harga_display');
        const totalHargaHidden = document.getElementById('total_harga_hidden');

        function calculateTotalPrice() {
            const selectedJadwalOption = jadwalSelect.options[jadwalSelect.selectedIndex];
            // Pastikan ada opsi yang terpilih sebelum mengakses dataset
            if (!selectedJadwalOption || selectedJadwalOption.value === "") {
                totalHargaDisplay.value = 'Rp 0';
                totalHargaHidden.value = 0;
                jumlahPesertaInput.setCustomValidity(''); // Reset validasi
                return;
            }

            const hargaIndividu = parseFloat(selectedJadwalOption.dataset.hargaIndividu || 0);
            const hargaKelompok = parseFloat(selectedJadwalOption.dataset.hargaKelompok || 0);
            const jumlahPeserta = parseInt(jumlahPesertaInput.value) || 0;

            let hargaPerPeserta = 0;
            let jenisPeserta = '';

            jenisPesertaRadios.forEach(radio => {
                if (radio.checked) {
                    jenisPeserta = radio.value;
                }
            });

            if (jenisPeserta === 'individu') {
                hargaPerPeserta = hargaIndividu;
            } else if (jenisPeserta === 'kelompok') {
                hargaPerPeserta = hargaKelompok;
            }

            const totalPrice = hargaPerPeserta * jumlahPeserta;
            totalHargaDisplay.value = 'Rp ' + totalPrice.toLocaleString('id-ID');
            totalHargaHidden.value = totalPrice;

            // Validasi jumlah peserta dengan slot tersisa
            const slotTersisaText = selectedJadwalOption.textContent;
            const match = slotTersisaText.match(/Slot Tersisa: (\d+)/);
            if (match) {
                const slotTersisa = parseInt(match[1]);
                if (jumlahPeserta > slotTersisa) {
                    jumlahPesertaInput.setCustomValidity('Jumlah peserta melebihi slot yang tersedia (' + slotTersisa + ').');
                } else {
                    jumlahPesertaInput.setCustomValidity('');
                }
            } else {
                jumlahPesertaInput.setCustomValidity('');
            }
        }

        // Tambahkan event listener
        jadwalSelect.addEventListener('change', calculateTotalPrice);
        jenisPesertaRadios.forEach(radio => radio.addEventListener('change', calculateTotalPrice));
        jumlahPesertaInput.addEventListener('input', calculateTotalPrice);

        // Panggil saat halaman dimuat untuk inisialisasi nilai jika ada old() value
        calculateTotalPrice();
    });
</script>
@endsection