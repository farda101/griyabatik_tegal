<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketWorkshop; // Import model PaketWorkshop
use App\Http\Requests\StorePaketWorkshopRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdatePaketWorkshopRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request; // Digunakan untuk method destroy dan toggle status
use Illuminate\Support\Facades\Session; // Digunakan untuk flash message
use Illuminate\Support\Facades\Log; // Digunakan untuk logging error

class PaketWorkshopController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua paket workshop.
     */
    public function index()
    {
        // Ambil semua data paket workshop, bisa ditambahkan pagination jika data banyak
        $paketWorkshops = PaketWorkshop::latest()->paginate(10); // Menampilkan 10 paket per halaman

        // Kirim data ke view
        return view('admin.paket_workshop.index', compact('paketWorkshops'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat paket workshop baru.
     */
    public function create()
    {
        return view('admin.paket_workshop.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan paket workshop baru ke database.
     *
     * @param  \App\Http\Requests\StorePaketWorkshopRequest  $request
     */
    public function store(StorePaketWorkshopRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StorePaketWorkshopRequest
            $data = $request->validated();

            PaketWorkshop::create($data);

            // Flash message sukses
            Session::flash('success', 'Paket workshop berhasil ditambahkan!');
            return redirect()->route('admin.paket_workshop.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal menyimpan paket workshop: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan paket workshop: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail paket workshop tertentu.
     *
     * @param  \App\Models\PaketWorkshop  $paketWorkshop
     */
    public function show(PaketWorkshop $paketWorkshop)
    {
        // Route Model Binding otomatis mengambil paketWorkshop berdasarkan ID di URL
        return view('admin.paket_workshop.show', compact('paketWorkshop'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data paket workshop.
     *
     * @param  \App\Models\PaketWorkshop  $paketWorkshop
     */
    public function edit(PaketWorkshop $paketWorkshop)
    {
        // Route Model Binding otomatis mengambil paketWorkshop berdasarkan ID di URL
        return view('admin.paket_workshop.edit', compact('paketWorkshop'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data paket workshop di database.
     *
     * @param  \App\Http\Requests\UpdatePaketWorkshopRequest  $request
     * @param  \App\Models\PaketWorkshop  $paketWorkshop
     */
    public function update(UpdatePaketWorkshopRequest $request, PaketWorkshop $paketWorkshop)
    {
        try {
            // Data sudah divalidasi oleh UpdatePaketWorkshopRequest
            $data = $request->validated();

            $paketWorkshop->update($data);

            // Flash message sukses
            Session::flash('success', 'Paket workshop berhasil diperbarui!');
            return redirect()->route('admin.paket_workshop.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui paket workshop: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui paket workshop: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus paket workshop dari database.
     *
     * @param  \App\Models\PaketWorkshop  $paketWorkshop
     */
    public function destroy(PaketWorkshop $paketWorkshop)
    {
        try {
            // Periksa apakah paket workshop ini memiliki jadwal yang terikat
            // Ini adalah langkah pencegahan agar tidak menghapus paket yang masih digunakan.
            if ($paketWorkshop->jadwalWorkshops()->exists()) {
                Session::flash('error', 'Paket workshop tidak dapat dihapus karena masih terikat dengan jadwal workshop yang ada.');
                return redirect()->back();
            }

            $paketWorkshop->delete();

            // Flash message sukses
            Session::flash('success', 'Paket workshop berhasil dihapus!');
            return redirect()->route('admin.paket_workshop.index');

        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal menghapus paket workshop: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus paket workshop: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Toggle the active status of a paket workshop.
     * Mengubah status aktif/non-aktif paket workshop.
     *
     * @param  \App\Models\PaketWorkshop  $paketWorkshop
     * @param  \Illuminate\Http\Request  $request
     */
    public function toggleStatus(Request $request, PaketWorkshop $paketWorkshop)
    {
        try {
            // Toggle nilai is_active
            $paketWorkshop->is_active = !$paketWorkshop->is_active;
            $paketWorkshop->save();

            $status = $paketWorkshop->is_active ? 'aktif' : 'non-aktif';
            Session::flash('success', "Status paket workshop '{$paketWorkshop->nama_paket}' berhasil diubah menjadi {$status}.");
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status paket workshop: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengubah status paket workshop: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}