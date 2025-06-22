<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;    // Import model Artikel
use App\Http\Requests\StoreArtikelRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdateArtikelRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Untuk upload/hapus file
use Illuminate\Support\Facades\Auth;   // Untuk mendapatkan user_id penulis
use Illuminate\Support\Str;             // Untuk string manipulation (slug)

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua artikel.
     */
    public function index()
    {
        // Ambil semua data artikel, dengan relasi ke penulis (user)
        $artikels = Artikel::with('author')
                            ->latest('created_at') // Urutkan berdasarkan tanggal dibuat terbaru
                            ->paginate(10); 

        return view('admin.artikel.index', compact('artikels'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return view('admin.artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan artikel baru ke database dan mengunggah gambar unggulan.
     *
     * @param  \App\Http\Requests\StoreArtikelRequest  $request
     */
    public function store(StoreArtikelRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StoreArtikelRequest
            $data = $request->validated();

            // Handle file upload 'featured_image'
            $featuredImagePath = null;
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                // Simpan file ke direktori 'articles' di storage
                $featuredImagePath = $file->store('articles', 'public');
                $data['featured_image'] = $featuredImagePath;
            }

            // Auto-generate slug dari judul
            $data['slug'] = Str::slug($data['judul']);
            // Pastikan slug unik (bisa tambahkan counter jika judul sama persis)
            $originalSlug = $data['slug'];
            $count = 1;
            while (Artikel::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $count++;
            }


            // Set views_count default 0
            $data['views_count'] = 0;
            
            // Set author_id ke user yang sedang login
            $data['author_id'] = Auth::id();

            // Set published_at jika status langsung published
            if ($data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }


            Artikel::create($data);

            // Flash message sukses
            Session::flash('success', 'Artikel berhasil ditambahkan!');
            return redirect()->route('admin.artikel.index');

        } catch (\Exception $e) {
            // Jika ada error setelah upload, pastikan file yang sudah terupload dihapus
            if (isset($featuredImagePath) && Storage::disk('public')->exists($featuredImagePath)) {
                Storage::disk('public')->delete($featuredImagePath);
            }
            // Log error untuk debugging
            Log::error('Gagal menyimpan artikel: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan artikel: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail artikel tertentu dan menambah views count.
     *
     * @param  \App\Models\Artikel  $artikel
     */
    public function show(Artikel $artikel)
    {
        // Tambah views count setiap kali artikel dilihat di halaman detail
        $artikel->incrementViews();
        return view('admin.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data artikel.
     *
     * @param  \App\Models\Artikel  $artikel
     */
    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data artikel di database dan mengunggah gambar unggulan baru jika ada.
     *
     * @param  \App\Http\Requests\UpdateArtikelRequest  $request
     * @param  \App\Models\Artikel  $artikel
     */
    public function update(UpdateArtikelRequest $request, Artikel $artikel)
    {
        try {
            // Data sudah divalidasi oleh UpdateArtikelRequest
            $data = $request->validated();

            $oldFeaturedImagePath = $artikel->featured_image;
            $newFeaturedImagePath = null;

            // Handle file upload 'featured_image' jika ada
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $newFeaturedImagePath = $file->store('articles', 'public');
                $data['featured_image'] = $newFeaturedImagePath;

                // Hapus gambar lama jika ada dan berhasil upload gambar baru
                if ($oldFeaturedImagePath && Storage::disk('public')->exists($oldFeaturedImagePath)) {
                    Storage::disk('public')->delete($oldFeaturedImagePath);
                }
            } else {
                // Jika tidak ada file baru di-upload, pastikan gambar lama tetap ada
                // Atau jika ada opsi hapus, tangani di sini.
                unset($data['featured_image']);
            }
            
            // Auto-generate/perbarui slug dari judul jika judul berubah
            if ($artikel->judul !== $data['judul']) {
                $data['slug'] = Str::slug($data['judul']);
                $originalSlug = $data['slug'];
                $count = 1;
                // Pastikan slug unik, kecuali untuk artikel yang sedang diedit
                while (Artikel::where('slug', $data['slug'])->where('id', '!=', $artikel->id)->exists()) {
                    $data['slug'] = $originalSlug . '-' . $count++;
                }
            }
            // views_count tidak diubah manual dari sini
            // author_id tidak diubah di sini

            // Set published_at jika status berubah menjadi published dan belum ada tanggal publikasi
            if ($data['status'] === 'published' && empty($artikel->published_at)) {
                $data['published_at'] = now();
            } elseif ($data['status'] === 'draft' && $artikel->published_at) {
                 // Jika status diubah kembali ke draft, hapus tanggal publikasi (opsional)
                 $data['published_at'] = null;
            }


            $artikel->update($data);

            // Flash message sukses
            Session::flash('success', 'Artikel berhasil diperbarui!');
            return redirect()->route('admin.artikel.index');

        } catch (\Exception $e) {
            // Jika ada error setelah upload file baru, pastikan file baru yang sudah terupload dihapus
            if (isset($newFeaturedImagePath) && $newFeaturedImagePath && Storage::disk('public')->exists($newFeaturedImagePath)) {
                Storage::disk('public')->delete($newFeaturedImagePath);
            }
            // Log error untuk debugging
            Log::error('Gagal memperbarui artikel: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui artikel: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus artikel dari database dan file gambar unggulannya.
     *
     * @param  \App\Models\Artikel  $artikel
     */
    public function destroy(Artikel $artikel)
    {
        try {
            // Hapus gambar unggulan terkait jika ada
            if ($artikel->featured_image && Storage::disk('public')->exists($artikel->featured_image)) {
                Storage::disk('public')->delete($artikel->featured_image);
            }

            $artikel->delete();

            // Flash message sukses
            Session::flash('success', 'Artikel berhasil dihapus!');
            return redirect()->route('admin.artikel.index');

        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal menghapus artikel: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus artikel: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Toggle the status of an article (draft/published).
     * Mengubah status aktif/non-aktif artikel.
     *
     * @param  \App\Models\Artikel  $artikel
     * @param  \Illuminate\Http\Request  $request
     */
    public function toggleStatus(Request $request, Artikel $artikel)
    {
        try {
            if ($artikel->status === 'published') {
                $artikel->update(['status' => 'draft', 'published_at' => null]);
                $statusPesan = 'Draft';
            } else {
                $artikel->update(['status' => 'published', 'published_at' => now()]);
                $statusPesan = 'Published';
            }
            Session::flash('success', "Status artikel '{$artikel->judul}' berhasil diubah menjadi {$statusPesan}.");
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Gagal mengubah status artikel: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengubah status artikel: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}