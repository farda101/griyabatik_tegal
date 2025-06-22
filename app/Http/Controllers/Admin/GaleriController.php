<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;    // Import model Galeri
use App\Http\Requests\StoreGaleriRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdateGaleriRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus file

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua foto galeri.
     */
    public function index()
    {
        // Ambil semua data galeri, diurutkan berdasarkan urutan tampilan
        $galeris = Galeri::orderBy('urutan')->latest('id')->paginate(10); // Atau bisa pakai latest() jika urutan tidak terlalu penting untuk index

        return view('admin.galeri.index', compact('galeris'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat foto galeri baru.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan foto galeri baru ke database dan mengunggah file gambar.
     *
     * @param  \App\Http\Requests\StoreGaleriRequest  $request
     */
    public function store(StoreGaleriRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StoreGaleriRequest
            $data = $request->validated();

            // Handle file upload 'foto'
            $filePath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                // Simpan file ke direktori 'galeri' di storage
                $filePath = $file->store('galeri', 'public');
                $data['foto'] = $filePath;
            }

            // Atur urutan jika tidak diisi (misal: urutan terakhir + 1)
            if (!isset($data['urutan']) || is_null($data['urutan'])) {
                $maxUrutan = Galeri::max('urutan');
                $data['urutan'] = $maxUrutan !== null ? $maxUrutan + 1 : 0; // Mulai dari 0 atau 1
            }

            Galeri::create($data);

            // Flash message sukses
            Session::flash('success', 'Foto galeri berhasil ditambahkan!');
            return redirect()->route('admin.galeri.index');

        } catch (\Exception $e) {
            // Jika ada error setelah upload file, pastikan file yang sudah terupload dihapus
            if (isset($filePath) && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            // Log error untuk debugging
            Log::error('Gagal menyimpan foto galeri: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan foto galeri: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail foto galeri tertentu.
     *
     * @param  \App\Models\Galeri  $galeri
     */
    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data foto galeri.
     *
     * @param  \App\Models\Galeri  $galeri
     */
    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data foto galeri di database dan mengunggah file gambar baru jika ada.
     *
     * @param  \App\Http\Requests\UpdateGaleriRequest  $request
     * @param  \App\Models\Galeri  $galeri
     */
    public function update(UpdateGaleriRequest $request, Galeri $galeri)
    {
        try {
            // Data sudah divalidasi oleh UpdateGaleriRequest
            $data = $request->validated();

            // Handle file upload 'foto' jika ada
            $oldFotoPath = $galeri->foto; // Simpan path foto lama
            $newFilePath = null;

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $newFilePath = $file->store('galeri', 'public');
                $data['foto'] = $newFilePath;

                // Hapus foto lama jika ada dan berhasil upload foto baru
                if ($oldFotoPath && Storage::disk('public')->exists($oldFotoPath)) {
                    Storage::disk('public')->delete($oldFotoPath);
                }
            } else {
                // Jika tidak ada file baru di-upload, pastikan foto lama tetap ada
                // Ini penting jika input file tidak disertakan di form (misal karena hanya update teks)
                // Atau jika Anda punya checkbox "hapus foto", maka perlu logicnya di sini.
                unset($data['foto']); // Pastikan tidak mengoverwrite dengan null jika tidak ada upload baru
            }

            $galeri->update($data);

            // Flash message sukses
            Session::flash('success', 'Foto galeri berhasil diperbarui!');
            return redirect()->route('admin.galeri.index');

        } catch (\Exception $e) {
            // Jika ada error setelah upload file baru, pastikan file baru yang sudah terupload dihapus
            if (isset($newFilePath) && $newFilePath && Storage::disk('public')->exists($newFilePath)) {
                Storage::disk('public')->delete($newFilePath);
            }
            // Log error untuk debugging
            Log::error('Gagal memperbarui foto galeri: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui foto galeri: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus foto galeri dari database dan file gambarnya.
     *
     * @param  \App\Models\Galeri  $galeri
     */
    public function destroy(Galeri $galeri)
    {
        try {
            // Hapus file foto terkait jika ada
            if ($galeri->foto && Storage::disk('public')->exists($galeri->foto)) {
                Storage::disk('public')->delete($galeri->foto);
            }

            $galeri->delete();

            // Flash message sukses
            Session::flash('success', 'Foto galeri berhasil dihapus!');
            return redirect()->route('admin.galeri.index');

        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal menghapus foto galeri: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus foto galeri: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Toggle the active status of a galeri item.
     * Mengubah status aktif/non-aktif foto galeri.
     *
     * @param  \App\Models\Galeri  $galeri
     * @param  \Illuminate\Http\Request  $request
     */
    public function toggleStatus(Request $request, Galeri $galeri)
    {
        try {
            $galeri->is_active = !$galeri->is_active;
            $galeri->save();

            $status = $galeri->is_active ? 'aktif' : 'non-aktif';
            Session::flash('success', "Status foto '{$galeri->judul}' berhasil diubah menjadi {$status}.");
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status foto galeri: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengubah status foto galeri: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}