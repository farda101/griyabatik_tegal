<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalWorkshop; // Import model JadwalWorkshop
use App\Models\PaketWorkshop;  // Import model PaketWorkshop (diperlukan untuk dropdown di form)
use App\Http\Requests\StoreJadwalWorkshopRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdateJadwalWorkshopRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request; // Digunakan untuk method destroy
use Illuminate\Support\Facades\Session; // Digunakan untuk flash message
use Illuminate\Support\Facades\Log; // Digunakan untuk logging error
use Carbon\Carbon; // Untuk manipulasi tanggal/waktu, sudah diimpor di model tapi bagus juga di controller

class JadwalWorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua jadwal workshop.
     */
    public function index()
    {
        // Ambil semua data jadwal workshop, dengan relasi ke PaketWorkshop, bisa ditambahkan pagination
        $jadwalWorkshops = JadwalWorkshop::with('paketWorkshop')
                            ->latest('tanggal') // Urutkan berdasarkan tanggal terbaru
                            ->latest('jam_mulai') // Lalu jam mulai terbaru
                            ->paginate(10); // Menampilkan 10 jadwal per halaman

        // Kirim data ke view
        return view('admin.jadwal_workshop.index', compact('jadwalWorkshops'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat jadwal workshop baru.
     */
    public function create()
    {
        // Ambil semua paket workshop yang aktif untuk dropdown
        $paketWorkshops = PaketWorkshop::active()->get();
        return view('admin.jadwal_workshop.create', compact('paketWorkshops'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan jadwal workshop baru ke database.
     *
     * @param  \App\Http\Requests\StoreJadwalWorkshopRequest  $request
     */
    public function store(StoreJadwalWorkshopRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StoreJadwalWorkshopRequest
            $data = $request->validated();

            // Status awal selalu 'available' saat membuat jadwal baru
            // Jika ada logic di model boot untuk default 'available', baris ini bisa diabaikan
            $data['status'] = 'available';

            // Set peserta_terdaftar ke 0 secara default saat membuat baru
            $data['peserta_terdaftar'] = 0;

            $jadwal = JadwalWorkshop::create($data);

            // Flash message sukses
            Session::flash('success', 'Jadwal workshop berhasil ditambahkan!');
            return redirect()->route('admin.jadwal_workshop.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal menyimpan jadwal workshop: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan jadwal workshop: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail jadwal workshop tertentu.
     *
     * @param  \App\Models\JadwalWorkshop  $jadwalWorkshop
     */
    public function show(JadwalWorkshop $jadwalWorkshop)
    {
        // Route Model Binding otomatis mengambil jadwalWorkshop berdasarkan ID di URL
        // Eager load paketWorkshop untuk ditampilkan di detail
        $jadwalWorkshop->load('paketWorkshop');
        return view('admin.jadwal_workshop.show', compact('jadwalWorkshop'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data jadwal workshop.
     *
     * @param  \App\Models\JadwalWorkshop  $jadwalWorkshop
     */
    public function edit(JadwalWorkshop $jadwalWorkshop)
    {
        // Route Model Binding otomatis mengambil jadwalWorkshop berdasarkan ID di URL
        // Ambil juga semua paket workshop yang aktif untuk dropdown
        $paketWorkshops = PaketWorkshop::active()->get();
        return view('admin.jadwal_workshop.edit', compact('jadwalWorkshop', 'paketWorkshops'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data jadwal workshop di database.
     *
     * @param  \App\Http\Requests\UpdateJadwalWorkshopRequest  $request
     * @param  \App\Models\JadwalWorkshop  $jadwalWorkshop
     */
    public function update(UpdateJadwalWorkshopRequest $request, JadwalWorkshop $jadwalWorkshop)
    {
        try {
            // Data sudah divalidasi oleh UpdateJadwalWorkshopRequest
            $data = $request->validated();

            // Pastikan peserta_terdaftar tidak melebihi max_peserta baru jika max_peserta diubah
            if ($data['max_peserta'] < $jadwalWorkshop->peserta_terdaftar) {
                Session::flash('error', 'Maksimal peserta tidak boleh kurang dari jumlah peserta yang sudah terdaftar.');
                return redirect()->back()->withInput();
            }

            $jadwalWorkshop->update($data);

            // Opsional: Perbarui status 'full' jika max_peserta baru membuat jadwal penuh
            // Ini juga bisa dilakukan oleh observer atau method di model
            if ($jadwalWorkshop->peserta_terdaftar >= $jadwalWorkshop->max_peserta && $jadwalWorkshop->status !== 'full') {
                $jadwalWorkshop->update(['status' => 'full']);
            } elseif ($jadwalWorkshop->peserta_terdaftar < $jadwalWorkshop->max_peserta && $jadwalWorkshop->status === 'full') {
                 // Jika sebelumnya penuh dan sekarang ada slot kosong, kembalikan ke available
                 // Kecuali jika status diubah secara manual ke 'unavailable'
                 if ($request->input('status') !== 'unavailable') {
                     $jadwalWorkshop->update(['status' => 'available']);
                 }
            }


            // Flash message sukses
            Session::flash('success', 'Jadwal workshop berhasil diperbarui!');
            return redirect()->route('admin.jadwal_workshop.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui jadwal workshop: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui jadwal workshop: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus jadwal workshop dari database.
     *
     * @param  \App\Models\JadwalWorkshop  $jadwalWorkshop
     */
    public function destroy(JadwalWorkshop $jadwalWorkshop)
    {
        try {
            // Periksa apakah jadwal ini memiliki reservasi yang terikat
            if ($jadwalWorkshop->reservasis()->exists()) {
                Session::flash('error', 'Jadwal workshop tidak dapat dihapus karena sudah memiliki reservasi.');
                return redirect()->back();
            }

            $jadwalWorkshop->delete();

            // Flash message sukses
            Session::flash('success', 'Jadwal workshop berhasil dihapus!');
            return redirect()->route('admin.jadwal_workshop.index');

        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal menghapus jadwal workshop: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus jadwal workshop: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Toggle the status of a jadwal workshop (available/unavailable).
     * Mengubah status ketersediaan jadwal workshop.
     *
     * @param  \App\Models\JadwalWorkshop  $jadwalWorkshop
     * @param  \Illuminate\Http\Request  $request
     */
    public function toggleStatus(Request $request, JadwalWorkshop $jadwalWorkshop)
    {
        try {
            // Kita tidak bisa langsung toggle karena ada 3 status: available, unavailable, full
            // Toggle ini akan mengelola antara 'available' dan 'unavailable' secara manual
            // Status 'full' diatur otomatis oleh sistem berdasarkan peserta terdaftar
            if ($jadwalWorkshop->status === 'available') {
                $jadwalWorkshop->update(['status' => 'unavailable']);
                $statusPesan = 'non-aktif';
            } elseif ($jadwalWorkshop->status === 'unavailable') {
                // Hanya bisa diaktifkan jika tidak penuh
                if ($jadwalWorkshop->peserta_terdaftar < $jadwalWorkshop->max_peserta) {
                    $jadwalWorkshop->update(['status' => 'available']);
                    $statusPesan = 'aktif';
                } else {
                    // Jika mencoba mengaktifkan jadwal yang sudah penuh
                    Session::flash('error', 'Jadwal tidak dapat diaktifkan karena sudah penuh.');
                    return redirect()->back();
                }
            } else { // Jika statusnya 'full'
                Session::flash('error', 'Status jadwal penuh tidak bisa diubah secara manual. Mohon sesuaikan jumlah peserta atau maksimal peserta.');
                return redirect()->back();
            }

            Session::flash('success', "Status jadwal workshop pada tanggal {$jadwalWorkshop->tanggal->format('d/m/Y')} ({$jadwalWorkshop->paketWorkshop->nama_paket}) berhasil diubah menjadi {$statusPesan}.");
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status jadwal workshop: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengubah status jadwal workshop: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}