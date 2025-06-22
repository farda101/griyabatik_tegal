<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenggunaanBahan;    // Import model PenggunaanBahan
use App\Models\StockBahan;         // Import model StockBahan (diperlukan untuk dropdown dan update stok)
use App\Http\Requests\StorePenggunaanBahanRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdatePenggunaanBahanRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user_id yang mencatat

class PenggunaanBahanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua catatan penggunaan bahan.
     */
    public function index()
    {
        // Ambil semua data penggunaan bahan, dengan relasi ke StockBahan dan User
        $penggunaanBahans = PenggunaanBahan::with(['stockBahan', 'user'])
                                ->latest('tanggal_penggunaan') // Urutkan berdasarkan tanggal penggunaan terbaru
                                ->latest('id') // Lalu ID terbaru
                                ->paginate(10); // Menampilkan 10 catatan per halaman

        return view('admin.penggunaan_bahan.index', compact('penggunaanBahans'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat catatan penggunaan bahan baru.
     */
    public function create()
    {
        // Ambil semua stok bahan yang tersedia (qty_tersedia > 0) untuk dropdown
        $stockBahans = StockBahan::available()->get();
        return view('admin.penggunaan_bahan.create', compact('stockBahans'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan catatan penggunaan bahan baru ke database dan mengurangi stok.
     *
     * @param  \App\Http\Requests\StorePenggunaanBahanRequest  $request
     */
    public function store(StorePenggunaanBahanRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StorePenggunaanBahanRequest
            $data = $request->validated();

            // Tambahkan user_id dari user yang sedang login
            $data['user_id'] = Auth::id();

            // Temukan bahan yang digunakan
            $stockBahan = StockBahan::find($data['stock_bahan_id']);

            // Lakukan pengurangan stok bahan menggunakan method di model StockBahan
            if (!$stockBahan->kurangiBahan($data['qty_digunakan'])) {
                // Seharusnya ini sudah ditangani oleh validasi Form Request, tapi ini sebagai fallback
                Session::flash('error', 'Stok bahan tidak cukup untuk penggunaan ini. Tersedia: ' . $stockBahan->qty_tersedia . ' ' . $stockBahan->satuan);
                return redirect()->back()->withInput();
            }

            // Buat catatan penggunaan bahan
            PenggunaanBahan::create($data);

            // Flash message sukses
            Session::flash('success', 'Catatan penggunaan bahan berhasil ditambahkan dan stok telah disesuaikan.');
            return redirect()->route('admin.penggunaan_bahan.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal menyimpan penggunaan bahan: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan penggunaan bahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail catatan penggunaan bahan tertentu.
     *
     * @param  \App\Models\PenggunaanBahan  $penggunaanBahan
     */
    public function show(PenggunaanBahan $penggunaanBahan)
    {
        // Eager load relasi untuk detail tampilan
        $penggunaanBahan->load(['stockBahan', 'user']);
        return view('admin.penggunaan_bahan.show', compact('penggunaanBahan'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit catatan penggunaan bahan.
     *
     * @param  \App\Models\PenggunaanBahan  $penggunaanBahan
     */
    public function edit(PenggunaanBahan $penggunaanBahan)
    {
        // Ambil semua stok bahan yang tersedia untuk dropdown (termasuk bahan yang sedang diedit)
        $stockBahans = StockBahan::available()->get(); // Atau StockBahan::all() jika non-aktif juga bisa dipilih
        return view('admin.penggunaan_bahan.edit', compact('penggunaanBahan', 'stockBahans'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui catatan penggunaan bahan di database dan menyesuaikan stok.
     *
     * @param  \App\Http\Requests\UpdatePenggunaanBahanRequest  $request
     * @param  \App\Models\PenggunaanBahan  $penggunaanBahan
     */
    public function update(UpdatePenggunaanBahanRequest $request, PenggunaanBahan $penggunaanBahan)
    {
        try {
            // Data sudah divalidasi oleh UpdatePenggunaanBahanRequest
            $data = $request->validated();

            // Simpan kuantitas lama dan ID bahan lama sebelum update
            $oldQtyUsed = $penggunaanBahan->qty_digunakan;
            $oldStockBahanId = $penggunaanBahan->stock_bahan_id;

            // Mulai transaksi database
            DB::beginTransaction(); // Pastikan DB facade di-import

            // 1. Kembalikan stok ke bahan lama (jika bahan diubah atau qty berkurang)
            $oldStockBahan = StockBahan::find($oldStockBahanId);
            if ($oldStockBahan) {
                $oldStockBahan->increment('qty_tersedia', $oldQtyUsed);
                $oldStockBahan->decrement('qty_terpakai', $oldQtyUsed);
            }

            // 2. Update catatan penggunaan bahan
            $penggunaanBahan->update($data);

            // 3. Kurangi stok dari bahan baru (atau bahan yang sama dengan qty baru)
            $newStockBahan = StockBahan::find($data['stock_bahan_id']);
            if (!$newStockBahan->kurangiBahan($data['qty_digunakan'])) {
                DB::rollBack(); // Rollback jika pengurangan stok gagal
                Session::flash('error', 'Gagal memperbarui penggunaan bahan: Stok bahan tidak cukup. Tersedia: ' . $newStockBahan->qty_tersedia . ' ' . $newStockBahan->satuan);
                return redirect()->back()->withInput();
            }

            DB::commit(); // Commit transaksi jika semua berhasil

            // Flash message sukses
            Session::flash('success', 'Catatan penggunaan bahan berhasil diperbarui dan stok telah disesuaikan.');
            return redirect()->route('admin.penggunaan_bahan.index');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika ada error
            // Log error untuk debugging
            Log::error('Gagal memperbarui penggunaan bahan: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui penggunaan bahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus catatan penggunaan bahan dari database dan mengembalikan stok.
     *
     * @param  \App\Models\PenggunaanBahan  $penggunaanBahan
     */
    public function destroy(PenggunaanBahan $penggunaanBahan)
    {
        try {
            // Mulai transaksi database
            DB::beginTransaction(); // Pastikan DB facade di-import

            // Temukan bahan yang terkait
            $stockBahan = StockBahan::find($penggunaanBahan->stock_bahan_id);

            if ($stockBahan) {
                // Kembalikan kuantitas yang telah digunakan ke stok tersedia
                $stockBahan->increment('qty_tersedia', $penggunaanBahan->qty_digunakan);
                $stockBahan->decrement('qty_terpakai', $penggunaanBahan->qty_digunakan);
                $stockBahan->save(); // Simpan perubahan stok
            }

            // Hapus catatan penggunaan bahan
            $penggunaanBahan->delete();

            DB::commit(); // Commit transaksi

            // Flash message sukses
            Session::flash('success', 'Catatan penggunaan bahan berhasil dihapus dan stok telah dikembalikan.');
            return redirect()->route('admin.penggunaan_bahan.index');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi
            // Log error
            Log::error('Gagal menghapus penggunaan bahan: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus penggunaan bahan: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}