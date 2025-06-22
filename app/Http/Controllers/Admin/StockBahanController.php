<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockBahan;    // Import model StockBahan
use App\Http\Requests\StoreStockBahanRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdateStockBahanRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class StockBahanController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua stok bahan.
     */
    public function index()
    {
        // Ambil semua data stok bahan, bisa ditambahkan pagination
        $stockBahans = StockBahan::latest('tanggal_masuk') // Urutkan berdasarkan tanggal masuk terbaru
                            ->latest('id') // Lalu ID terbaru
                            ->paginate(10); // Menampilkan 10 item per halaman

        return view('admin.stock_bahan.index', compact('stockBahans'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat stok bahan baru.
     */
    public function create()
    {
        return view('admin.stock_bahan.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan stok bahan baru ke database.
     *
     * @param  \App\Http\Requests\StoreStockBahanRequest  $request
     */
    public function store(StoreStockBahanRequest $request)
    {
        try {
            // Data sudah divalidasi oleh StoreStockBahanRequest
            $data = $request->validated();

            // qty_tersedia akan sama dengan qty_masuk saat pertama kali
            // total_harga akan dihitung otomatis (qty_masuk * harga_satuan)
            // kode_bahan akan di-auto-generate
            // qty_terpakai default 0
            // Semua logika ini sudah diatur di model StockBahan (boot method)

            StockBahan::create($data);

            // Flash message sukses
            Session::flash('success', 'Stok bahan berhasil ditambahkan!');
            return redirect()->route('admin.stock_bahan.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal menyimpan stok bahan: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menambahkan stok bahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail stok bahan tertentu.
     *
     * @param  \App\Models\StockBahan  $stockBahan
     */
    public function show(StockBahan $stockBahan)
    {
        return view('admin.stock_bahan.show', compact('stockBahan'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data stok bahan.
     *
     * @param  \App\Models\StockBahan  $stockBahan
     */
    public function edit(StockBahan $stockBahan)
    {
        return view('admin.stock_bahan.edit', compact('stockBahan'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data stok bahan di database.
     *
     * @param  \App\Http\Requests\UpdateStockBahanRequest  $request
     * @param  \App\Models\StockBahan  $stockBahan
     */
    public function update(UpdateStockBahanRequest $request, StockBahan $stockBahan)
    {
        try {
            // Data sudah divalidasi oleh UpdateStockBahanRequest
            $data = $request->validated();

            // qty_masuk, qty_tersedia, qty_terpakai, total_harga tidak diubah manual dari sini
            // Hanya informasi non-kuantitas dan harga satuan yang bisa diubah.
            // total_harga akan dihitung ulang di model jika harga_satuan atau qty_masuk berubah
            // Namun, karena qty_masuk tidak diubah di sini, total_harga tidak perlu dihitung ulang.
            // $stockBahan->total_harga = $stockBahan->qty_masuk * $data['harga_satuan']; // Ini jika qty_masuk tidak read-only

            $stockBahan->update($data);

            // Flash message sukses
            Session::flash('success', 'Data stok bahan berhasil diperbarui!');
            return redirect()->route('admin.stock_bahan.index');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Gagal memperbarui stok bahan: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat memperbarui stok bahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus stok bahan dari database.
     *
     * @param  \App\Models\StockBahan  $stockBahan
     */
    public function destroy(StockBahan $stockBahan)
    {
        try {
            // Periksa apakah bahan ini sudah pernah digunakan (ada di penggunaan_bahans)
            if ($stockBahan->penggunaanBahans()->exists()) {
                Session::flash('error', 'Stok bahan tidak dapat dihapus karena sudah ada dalam riwayat penggunaan.');
                return redirect()->back();
            }

            // Hapus QR Code terkait jika ada (jika Anda pernah mengimplementasikannya)
            // if ($stockBahan->qr_code && Storage::disk('public')->exists($stockBahan->qr_code)) {
            //     Storage::disk('public')->delete($stockBahan->qr_code);
            // }

            $stockBahan->delete();

            // Flash message sukses
            Session::flash('success', 'Stok bahan berhasil dihapus!');
            return redirect()->route('admin.stock_bahan.index');

        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal menghapus stok bahan: ' . $e->getMessage(), ['exception' => $e]);
            // Flash message error
            Session::flash('error', 'Terjadi kesalahan saat menghapus stok bahan: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Download the QR Code for a stock bahan.
     * Mengunduh QR Code stok bahan.
     * (Opsional, jika Anda mengimplementasikan QR Code untuk bahan baku)
     *
     * @param  \App\Models\StockBahan  $stockBahan
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    // public function downloadQrCode(StockBahan $stockBahan)
    // {
    //     if ($stockBahan->qr_code && Storage::disk('public')->exists($stockBahan->qr_code)) {
    //         $fileName = basename($stockBahan->qr_code);
    //         $downloadName = 'QR_Bahan_' . $stockBahan->kode_bahan . '.svg';
    //         return Storage::download('public/' . $stockBahan->qr_code, $downloadName);
    //     }

    //     Session::flash('error', 'QR Code tidak ditemukan.');
    //     return redirect()->back();
    // }
}