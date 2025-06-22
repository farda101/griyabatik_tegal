<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengrajin; // Import model Pengrajin
use App\Http\Requests\StorePengrajinRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdatePengrajinRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request; // Digunakan untuk method destroy dan toggle status
use Illuminate\Support\Facades\Session; // Digunakan untuk flash message
use Illuminate\Support\Facades\Log; // Digunakan untuk logging error

class PengrajinController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua pengrajin.
     */
    public function index()
    {
        // Ambil semua data pengrajin, bisa ditambahkan pagination jika data banyak
        $pengrajins = Pengrajin::latest()->paginate(10); // Menampilkan 10 pengrajin per halaman

        // Kirim data ke view
        return view('admin.pengrajin.index', compact('pengrajins'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat pengrajin baru.
     */
    public function create()
    {
        return view('admin.pengrajin.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan pengrajin baru ke database.
     *
     * @param  \App\Http\Requests\StorePengrajinRequest  $request
     */
    public function store(StorePengrajinRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StorePengrajinRequest
            $data = $request->validated();

            // Kode pengrajin sudah di-generate otomatis di model (jika ada logic di model boot)
            // Atau Anda bisa generate di sini sebelum create jika tidak di model
            // Contoh: $data['kode_pengrajin'] = Pengrajin::generateKodePengrajin(); // Jika ada method ini di model

            Pengrajin::create($data);

            // Flash message sukses
            Session::flash('success', 'Data pengrajin berhasil ditambahkan!');
            return redirect()->route('admin.pengrajin.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal menyimpan pengrajin: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan pengrajin: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail pengrajin tertentu.
     *
     * @param  \App\Models\Pengrajin  $pengrajin
     */
    public function show(Pengrajin $pengrajin)
    {
        // Route Model Binding otomatis mengambil pengrajin berdasarkan ID di URL
        return view('admin.pengrajin.show', compact('pengrajin'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data pengrajin.
     *
     * @param  \App\Models\Pengrajin  $pengrajin
     */
    public function edit(Pengrajin $pengrajin)
    {
        // Route Model Binding otomatis mengambil pengrajin berdasarkan ID di URL
        return view('admin.pengrajin.edit', compact('pengrajin'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data pengrajin di database.
     *
     * @param  \App\Http\Requests\UpdatePengrajinRequest  $request
     * @param  \App\Models\Pengrajin  $pengrajin
     */
    public function update(UpdatePengrajinRequest $request, Pengrajin $pengrajin)
    {
        try {
            // Data sudah divalidasi oleh UpdatePengrajinRequest
            $data = $request->validated();

            $pengrajin->update($data);

            // Flash message sukses
            Session::flash('success', 'Data pengrajin berhasil diperbarui!');
            return redirect()->route('admin.pengrajin.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui pengrajin: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui pengrajin: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus pengrajin dari database.
     *
     * @param  \App\Models\Pengrajin  $pengrajin
     */
    public function destroy(Pengrajin $pengrajin)
    {
        try {
            $pengrajin->delete();

            // Flash message sukses
            Session::flash('success', 'Pengrajin berhasil dihapus!');
            return redirect()->route('admin.pengrajin.index');

        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal menghapus pengrajin: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus pengrajin: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Toggle the active status of a pengrajin.
     * Mengubah status aktif/non-aktif pengrajin.
     *
     * @param  \App\Models\Pengrajin  $pengrajin
     * @param  \Illuminate\Http\Request  $request
     */
    public function toggleStatus(Request $request, Pengrajin $pengrajin)
    {
        try {
            // Toggle nilai is_active
            $pengrajin->is_active = !$pengrajin->is_active;
            $pengrajin->save();

            $status = $pengrajin->is_active ? 'aktif' : 'non-aktif';
            Session::flash('success', "Status pengrajin '{$pengrajin->nama_pengrajin}' berhasil diubah menjadi {$status}.");
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status pengrajin: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengubah status pengrajin: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}