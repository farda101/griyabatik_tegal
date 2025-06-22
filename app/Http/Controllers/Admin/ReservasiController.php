<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservasi; // Model Reservasi
use App\Models\JadwalWorkshop; // Diperlukan untuk update peserta terdaftar
use App\Http\Requests\UpdateReservasiRequest; // Form Request untuk validasi update
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Untuk download/hapus file
use Illuminate\Support\Facades\DB; // Import DB Facade
use App\Jobs\SendWhatsAppNotification; // Tambahkan ini
use Carbon\Carbon; // Tambahkan ini, sudah di-import sebelumnya
use App\Exports\ReservasiExport; // Tambahkan ini
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua reservasi untuk admin.
     */
    public function index()
    {
        // Ambil semua reservasi dengan eager loading relasi yang diperlukan
        $reservasis = Reservasi::with(['jadwalWorkshop', 'jadwalWorkshop.paketWorkshop'])
                                ->latest() // Urutkan dari reservasi terbaru
                                ->paginate(10); // Paginate 10 per halaman

        return view('admin.reservasi.index', compact('reservasis'));
    }

    /**
     * Show the form for creating a new resource.
     * Tidak diperlukan untuk admin karena reservasi dibuat dari sisi publik.
     * Anda bisa mengarahkan ke halaman index atau tampilkan error.
     */
    public function create()
    {
        return redirect()->route('admin.reservasi.index')->with('info', 'Reservasi hanya bisa dibuat melalui form publik.');
    }

    /**
     * Store a newly created resource in storage.
     * Tidak diperlukan untuk admin karena reservasi dibuat dari sisi publik.
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.reservasi.index')->with('info', 'Reservasi hanya bisa dibuat melalui form publik.');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail reservasi tertentu untuk admin.
     *
     * @param  \App\Models\Reservasi  $reservasi
     */
    public function show(Reservasi $reservasi)
    {
        // Eager load relasi untuk detail tampilan
        $reservasi->load(['jadwalWorkshop', 'jadwalWorkshop.paketWorkshop']);
        return view('admin.reservasi.show', compact('reservasi'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data reservasi untuk admin.
     *
     * @param  \App\Models\Reservasi  $reservasi
     */
    public function edit(Reservasi $reservasi)
    {
        // Eager load relasi
        $reservasi->load(['jadwalWorkshop', 'jadwalWorkshop.paketWorkshop']);

        // Jika Anda ingin admin bisa mengubah jadwal, Anda perlu mengambil daftar jadwal yang tersedia
        // $jadwalWorkshops = JadwalWorkshop::available()->get();
        // return view('admin.reservasi.edit', compact('reservasi', 'jadwalWorkshops'));
        // Untuk sekarang, kita anggap jadwal tidak bisa diubah langsung via edit ini
        return view('admin.reservasi.edit', compact('reservasi'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data reservasi di database oleh admin.
     *
     * @param  \App\Http\Requests\UpdateReservasiRequest  $request
     * @param  \App\Models\Reservasi  $reservasi
     */
    public function update(UpdateReservasiRequest $request, Reservasi $reservasi)
    {
        try {
            $data = $request->validated();

            // Simpan status pembayaran lama untuk perbandingan
            $oldStatusPembayaran = $reservasi->status_pembayaran;

            // Handle file upload ulang jika ada
            if ($request->hasFile('file_permohonan')) {
                // Hapus file lama jika ada
                if ($reservasi->file_permohonan && Storage::disk('public')->exists($reservasi->file_permohonan)) {
                    Storage::disk('public')->delete($reservasi->file_permohonan);
                }
                $file = $request->file('file_permohonan');
                $filePath = $file->store('reservasi_permohonan', 'public');
                $data['file_permohonan'] = $filePath;
            } else {
                if (isset($data['file_permohonan_action']) && $data['file_permohonan_action'] === 'delete') {
                    if ($reservasi->file_permohonan && Storage::disk('public')->exists($reservasi->file_permohonan)) {
                        Storage::disk('public')->delete($reservasi->file_permohonan);
                    }
                    $data['file_permohonan'] = null;
                } else {
                    unset($data['file_permohonan']);
                }
            }
            unset($data['file_permohonan_action']);

            // Mulai transaksi database
            DB::beginTransaction();

            $reservasi->update($data);

            // Logic khusus jika status pembayaran berubah menjadi 'paid' atau dari 'paid'
            if ($oldStatusPembayaran !== 'paid' && $reservasi->status_pembayaran === 'paid') {
                $reservasi->update(['paid_at' => now()]);
                $reservasi->jadwalWorkshop->updatePesertaTerdaftar();

                // --- Pemicu Notifikasi WhatsApp: Pembayaran Lunas ---
                // Pastikan $reservasi->telepon_pemesan tidak mengandung tanda '+' saat disimpan
                // Nomor telepon harus dimulai dengan kode negara (misal 62)
                $phoneNumberClean = ltrim($reservasi->telepon_pemesan, '+'); // Hapus '+' jika ada
                $message = "Halo {$reservasi->nama_pemesan},\n\nPembayaran reservasi Anda dengan nomor {$reservasi->nomor_reservasi} untuk workshop '{$reservasi->jadwalWorkshop->paketWorkshop->nama_paket}' pada tanggal {$reservasi->jadwalWorkshop->tanggal->format('d M Y')} pukul {$reservasi->jadwalWorkshop->jam_mulai->format('H:i')} telah LUNAS.\n\nSampai jumpa di workshop!\nWorkshop Batik Tegalan";
                SendWhatsAppNotification::dispatch($phoneNumberClean, $message, $reservasi->id);
                // --- Akhir Pemicu Notifikasi ---

                Session::flash('success', 'Reservasi berhasil diperbarui dan status pembayaran diubah menjadi Lunas. Notifikasi WhatsApp telah dikirim. Jumlah peserta jadwal sudah diperbarui.');
            } elseif ($oldStatusPembayaran === 'paid' && $reservasi->status_pembayaran !== 'paid') {
                // Logic jika status berubah dari 'paid' ke non-'paid'
                $reservasi->jadwalWorkshop->decrement('peserta_terdaftar', $reservasi->jumlah_peserta);
                $reservasi->jadwalWorkshop->updatePesertaTerdaftar();
                $reservasi->update(['paid_at' => null]);
                Session::flash('warning', 'Reservasi berhasil diperbarui dan status pembayaran diubah dari Lunas. Jumlah peserta jadwal telah disesuaikan.');
            } else {
                Session::flash('success', 'Reservasi berhasil diperbarui!');
            }

            DB::commit();

            return redirect()->route('admin.reservasi.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui reservasi oleh admin: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            Session::flash('error', 'Terjadi kesalahan saat memperbarui reservasi: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus reservasi dari database oleh admin.
     *
     * @param  \App\Models\Reservasi  $reservasi
     */
    public function destroy(Reservasi $reservasi)
    {
        try {
            // Hapus file permohonan terkait jika ada
            if ($reservasi->file_permohonan && Storage::disk('public')->exists($reservasi->file_permohonan)) {
                Storage::disk('public')->delete($reservasi->file_permohonan);
            }

            // Jika reservasi sebelumnya PAID, kurangi jumlah peserta terdaftar di jadwal
            if ($reservasi->status_pembayaran === 'paid') {
                $reservasi->jadwalWorkshop->decrement('peserta_terdaftar', $reservasi->jumlah_peserta);
                // Setelah dikurangi, perbarui status jadwal jika sebelumnya penuh
                $reservasi->jadwalWorkshop->updatePesertaTerdaftar(); // Ini akan cek dan set status ke available jika ada slot
            }

            $reservasi->delete();

            Session::flash('success', 'Reservasi berhasil dihapus!');
            return redirect()->route('admin.reservasi.index');

        } catch (\Exception $e) {
            Log::error('Gagal menghapus reservasi oleh admin: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat menghapus reservasi: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Download the application file for a reservation.
     * Mengunduh file permohonan reservasi.
     *
     * @param  \App\Models\Reservasi  $reservasi
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadFilePermohonan(Reservasi $reservasi)
    {
        if ($reservasi->file_permohonan && Storage::disk('public')->exists($reservasi->file_permohonan)) {
            $fileName = basename($reservasi->file_permohonan); // Nama file asli yang disimpan
            $downloadName = 'Permohonan_Reservasi_' . $reservasi->nomor_reservasi . '_' . $fileName;

            // Perbaikan ada di baris ini: Panggil download langsung dari facade Storage
            return Storage::download('public/' . $reservasi->file_permohonan, $downloadName);
        }

        Session::flash('error', 'File permohonan tidak ditemukan.');
        return redirect()->back();
    }
    
     /**
     * Export reservation data to Excel.
     * Mengunduh data reservasi ke file Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function export()
    {
        try {
            $fileName = 'reservasi_data_' . Carbon::now()->format('Ymd_His') . '.xlsx';
            
            return Excel::download(new ReservasiExport, $fileName);
            
        } catch (\Exception $e) {
            Log::error('Gagal mengekspor data reservasi: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengekspor data reservasi: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}