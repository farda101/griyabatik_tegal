<?php

namespace App\Http\Controllers;

use App\Models\JadwalWorkshop; // Untuk mendapatkan jadwal yang tersedia
use App\Models\PaketWorkshop;  // Untuk mendapatkan detail paket workshop
use App\Models\Reservasi;      // Model Reservasi
use App\Models\User;      // Model User
use App\Http\Requests\StoreReservasiRequest; // Form Request untuk validasi saat menyimpan reservasi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;     // Tambahkan baris ini!
use App\Services\MidtransService;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmation;

class ReservasiController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
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
            ->whereHas('paketWorkshop', function($query) {
                $query->whereRaw('jadwal_workshops.tanggal >= DATE_ADD(CURDATE(), INTERVAL paket_workshops.max_reservation_days DAY)');
            })
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        // Ambil semua paket workshop yang aktif untuk informasi harga di form (opsional, bisa juga diambil dari jadwal)
        $paketWorkshops = PaketWorkshop::active()->get();

        $user = Auth::User();
        $name = "";
        $email = "";
        if (Auth::check()) {
            $email = $user->email;
            $name = $user->name;
        }

        return view('reservasi.create', compact('jadwalWorkshops', 'paketWorkshops', 'email', 'name'));
    }

    /**
     * Store a newly created reservation in storage.
     * Memproses pengajuan reservasi dari form publik.
     *
     * @param  \App\Http\Requests\StoreReservasiRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * Menampilkan daftar reservasi milik user yang sedang login.
     * Hanya user yang sudah login bisa mengakses.
     */
    public function myReservations(Request $request)
    {
        $user = auth()->user();

        // Query berdasarkan email user yang sedang login
        $query = \App\Models\Reservasi::with(['jadwalWorkshop.paketWorkshop'])
            ->where('email_pemesan', $user->email);

        // Filter (opsional)
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_reservasi', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pemesan', 'like', '%' . $request->search . '%');
            });
        }

        $reservasis = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Tampilkan ke view reservasi/saya.blade.php
        return view('reservasi.saya', compact('reservasis'));
    }

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
            $hargaPerPeserta = $paket->harga_kelompok;
            $data['total_harga'] = $hargaPerPeserta * $data['jumlah_peserta'];

            // Status pembayaran awal selalu 'pending'
            $data['status_pembayaran'] = 'pending';

            if (!Auth::check()) {
                $user = User::create([
                    "name" => $data['nama_pemesan'],
                    "email" => $data['email_pemesan'],
                    "password" => Hash::make($data['password']),
                    "role" => 'client',
                    "is_active" => true
                ]);

                event(new Registered($user));

                Auth::login($user);
            }

            $data['user_id'] = Auth::User()->id;

            $reservasi = Reservasi::create($data);

            // Kirim email konfirmasi reservasi
            try {
                Mail::to($reservasi->email_pemesan)->send(new ReservationConfirmation($reservasi));
            } catch (\Exception $e) {
                // Log error email tapi jangan gagal proses reservasi
                Log::error('Gagal mengirim email konfirmasi reservasi: ' . $e->getMessage(), ['reservasi_id' => $reservasi->id]);
            }

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
        $params = array(
            'transaction_details' => array(
                'order_id' => $reservasi['id'],
                'gross_amount' => $reservasi['total_harga'],
            )
        );

        $snapToken = $this->midtransService->createTransaction($params);
        $reservasi->storeSnapToken($snapToken);

        return view('reservasi.payment_instructions', compact('reservasi', 'snapToken'));
    }

    public function handlePaymentSuccess(Request $request, Reservasi $reservasi)
    {
        $midtransResponse = $request->input('data');
        // $midtransResponse = $request->data;
        $reservasi->handleReservationPaymentSuccess($midtransResponse);
        return response()->json(([
            'redirect' => route('reservasi.my')
        ]));
    }
}
