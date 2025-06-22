<?php

namespace App\Http\Controllers;

use App\Models\JadwalWorkshop; // Untuk mendapatkan jadwal yang tersedia
use App\Models\PaketWorkshop;  // Untuk mendapatkan detail paket workshop
use App\Models\Reservasi;      // Model Reservasi
use App\Http\Requests\StoreReservasiRequest; // Form Request untuk validasi saat menyimpan reservasi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Untuk upload file
use Illuminate\Support\Facades\DB;     // Tambahkan baris ini!

class ReservasiController extends Controller
{
    /**
     * Show the form for creating a new reservation.
     * Menampilkan form reservasi untuk publik.
     */
    public function create()
    {
        // Ambil jadwal workshop yang tersedia (available) dan belum penuh,
        // diurutkan berdasarkan tanggal dan jam terdekat di masa depan.
        // Eager load paketWorkshop untuk menampilkan nama paket.
        $jadwalWorkshops = JadwalWorkshop::with('paketWorkshop')
                            ->available() // Gunakan scope 'available' dari model JadwalWorkshop
                            ->where('peserta_terdaftar', '<', DB::raw('max_peserta')) // Perbaikan: Gunakan DB::raw
                            ->where('tanggal', '>=', now()->toDateString()) // Hanya jadwal hari ini atau di masa depan
                            ->orderBy('tanggal')
                            ->orderBy('jam_mulai')
                            ->get();

        // Ambil semua paket workshop yang aktif untuk informasi harga di form (opsional, bisa juga diambil dari jadwal)
        $paketWorkshops = PaketWorkshop::active()->get();

        return view('reservasi.create', compact('jadwalWorkshops', 'paketWorkshops'));
    }

    /**
     * Store a newly created reservation in storage.
     * Memproses pengajuan reservasi dari form publik.
     *
     * @param  \App\Http\Requests\StoreReservasiRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreReservasiRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle file upload (jika ada)
            $filePath = null;
            if ($request->hasFile('file_permohonan')) {
                $file = $request->file('file_permohonan');
                // Simpan file ke direktori 'reservasi_permohonan' di storage
                $filePath = $file->store('reservasi_permohonan', 'public');
                $data['file_permohonan'] = $filePath;
            }

            // Dapatkan detail jadwal workshop untuk kalkulasi harga
            $jadwal = JadwalWorkshop::with('paketWorkshop')->findOrFail($data['jadwal_workshop_id']);
            $paket = $jadwal->paketWorkshop;

            // Kalkulasi total harga berdasarkan jenis peserta dan jumlah peserta
            // Pastikan paket dan harga ditemukan
            if (!$paket) {
                throw new \Exception("Paket workshop tidak ditemukan untuk jadwal yang dipilih.");
            }
            $hargaPerPeserta = ($data['jenis_peserta'] === 'individu') ? $paket->harga_individu : $paket->harga_kelompok;
            $data['total_harga'] = $hargaPerPeserta * $data['jumlah_peserta'];

            // Status pembayaran awal selalu 'pending'
            $data['status_pembayaran'] = 'pending';

            $reservasi = Reservasi::create($data);

            // Logika updatePesertaTerdaftar TIDAK dipanggil di sini karena status masih 'pending'.

            // --- PERUBAHAN DI SINI UNTUK MENGIRIM ID VIA URL PARAMETER ---
            Session::flash('success', 'Reservasi Anda berhasil diajukan! Mohon lakukan pembayaran secara manual.');
            return redirect()->route('reservasi.payment_instructions', ['reservasi' => $reservasi->id]); // Kirim ID sebagai parameter route
            // --- AKHIR PERUBAHAN ---

        } catch (\Exception $e) {
            Log::error('Gagal mengajukan reservasi: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            Session::flash('error', 'Terjadi kesalahan saat mengajukan reservasi. Silakan coba lagi. ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for checking reservation status.
     * Menampilkan form untuk mencari status reservasi (publik).
     */
    public function showStatusCheckForm()
    {
        return view('reservasi.status_check_form');
    }

    /**
     * Display the specified reservation status.
     * Menampilkan detail status reservasi berdasarkan nomor reservasi yang diinput.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'nomor_reservasi' => 'required|string|max:15',
        ], [
            'nomor_reservasi.required' => 'Nomor reservasi wajib diisi.',
            'nomor_reservasi.max' => 'Nomor reservasi maksimal 15 karakter.',
        ]);

        $nomorReservasi = strtoupper($request->input('nomor_reservasi'));

        $reservasi = Reservasi::with(['jadwalWorkshop', 'jadwalWorkshop.paketWorkshop'])
                                ->where('nomor_reservasi', $nomorReservasi)
                                ->first();

        if (!$reservasi) {
            Session::flash('error', 'Nomor reservasi tidak ditemukan.');
            return redirect()->back()->withInput();
        }

        return view('reservasi.status', compact('reservasi'));
    }

    // --- Tambahkan metode baru untuk menampilkan instruksi pembayaran manual ---
    // Gunakan Route Model Binding untuk mengambil reservasi dari URL parameter
    public function showPaymentInstructions(Reservasi $reservasi) // Parameter diubah menjadi objek Reservasi
    {
        // Objek $reservasi otomatis sudah ditemukan dan di-inject oleh Route Model Binding
        // Jadi tidak perlu lagi cek session atau findOrFail
        return view('reservasi.payment_instructions', compact('reservasi'));
    }
}