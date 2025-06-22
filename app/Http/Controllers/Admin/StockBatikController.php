<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockBatik;    // Import model StockBatik
use App\Models\Pengrajin;     // Import model Pengrajin (untuk dropdown di form)
use App\Http\Requests\StoreStockBatikRequest; // Import Form Request untuk menyimpan
use App\Http\Requests\UpdateStockBatikRequest; // Import Form Request untuk memperbarui
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Untuk menyimpan QR Code
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import QR Code Facade
use Carbon\Carbon; // Tambahkan ini jika Anda menggunakan Carbon di controller
use App\Exports\StockBatikExport; // Tambahkan ini
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini

class StockBatikController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua stok batik.
     */
    public function index()
    {
        $stockBatiks = StockBatik::with('pengrajin')
                            ->latest('tanggal_masuk')
                            ->latest('id')
                            ->paginate(10);

        return view('admin.stock_batik.index', compact('stockBatiks'));
    }

    /**
     * Show the form for creating a new resource.
     * Menampilkan form untuk membuat stok batik baru.
     */
    public function create()
    {
        $pengrajins = Pengrajin::active()->get();
        return view('admin.stock_batik.create', compact('pengrajins'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan stok batik baru ke database, termasuk generate kode dan QR Code.
     *
     * @param  \App\Http\Requests\StoreStockBatikRequest  $request
     */
    public function store(StoreStockBatikRequest $request)
    {
        try {
            $data = $request->validated();

            // Set qty_tersedia sama dengan qty_masuk saat pertama kali
            // Ini bisa dihapus jika sudah diatur di model boot()
            // $data['qty_tersedia'] = $data['qty_masuk'];
            // $data['qty_terjual'] = 0; // Ini juga bisa dihapus jika sudah diatur di model boot()

            // Buat entri StockBatik. Kode batik akan di-generate otomatis di model boot()
            $stockBatik = StockBatik::create($data); // Kode batik sudah terisi di sini

            // Generate QR Code setelah kode_batik didapatkan
            $qrCodeData = json_encode([
                'kode' => $stockBatik->kode_batik,
                'nama' => $stockBatik->nama_batik,
                'pengrajin' => $stockBatik->pengrajin->nama_pengrajin ?? 'N/A', // Tambahkan 'N/A' untuk keamanan
                'harga_jual' => $stockBatik->harga_jual,
                'tanggal_masuk' => $stockBatik->tanggal_masuk->format('Y-m-d'),
            ]);

            $qrCodeFileName = 'batik_' . $stockBatik->kode_batik . '.svg';
            $qrCodePath = 'qr_codes/batik/' . $qrCodeFileName;

            Storage::disk('public')->put($qrCodePath, QrCode::size(200)->format('svg')->generate($qrCodeData));

            $stockBatik->update(['qr_code' => $qrCodePath]);

            Session::flash('success', 'Stok batik berhasil ditambahkan! Kode Batik: ' . $stockBatik->kode_batik . ' & QR Code berhasil digenerate.');
            return redirect()->route('admin.stock_batik.index');

        } catch (\Exception $e) {
            Log::error('Gagal menyimpan stok batik: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            Session::flash('error', 'Terjadi kesalahan saat menambahkan stok batik: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     * Menampilkan detail stok batik tertentu, termasuk QR Code.
     *
     * @param  \App\Models\StockBatik  $stockBatik
     */
    public function show(StockBatik $stockBatik)
    {
        $stockBatik->load('pengrajin');
        return view('admin.stock_batik.show', compact('stockBatik'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menampilkan form untuk mengedit data stok batik.
     *
     * @param  \App\Models\StockBatik  $stockBatik
     */
    public function edit(StockBatik $stockBatik)
    {
        $pengrajins = Pengrajin::active()->get();
        return view('admin.stock_batik.edit', compact('stockBatik', 'pengrajins'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data stok batik di database.
     *
     * @param  \App\Http\Requests\UpdateStockBatikRequest  $request
     * @param  \App\Models\StockBatik  $stockBatik
     */
    public function update(UpdateStockBatikRequest $request, StockBatik $stockBatik)
    {
        try {
            $data = $request->validated();
            $stockBatik->update($data);
            Session::flash('success', 'Data stok batik berhasil diperbarui!');
            return redirect()->route('admin.stock_batik.index');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui stok batik: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            Session::flash('error', 'Terjadi kesalahan saat memperbarui stok batik: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus stok batik dari database.
     *
     * @param  \App\Models\StockBatik  $stockBatik
     */
    public function destroy(StockBatik $stockBatik)
    {
        try {
            if ($stockBatik->qty_terjual > 0) { // Cek qty_terjual, bukan hanya exists()
                 Session::flash('error', 'Stok batik tidak dapat dihapus karena sudah ada yang terjual.');
                 return redirect()->back();
            }

            // Hapus QR Code terkait jika ada
            if ($stockBatik->qr_code && Storage::disk('public')->exists($stockBatik->qr_code)) {
                Storage::disk('public')->delete($stockBatik->qr_code);
            }

            $stockBatik->delete();
            Session::flash('success', 'Stok batik berhasil dihapus!');
            return redirect()->route('admin.stock_batik.index');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus stok batik: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat menghapus stok batik: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Download the QR Code for a stock batik.
     * Mengunduh QR Code stok batik.
     *
     * @param  \App\Models\StockBatik  $stockBatik
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function downloadQrCode(StockBatik $stockBatik)
    {
        if ($stockBatik->qr_code && Storage::disk('public')->exists($stockBatik->qr_code)) {
            $fileName = basename($stockBatik->qr_code);
            $downloadName = 'QR_Batik_' . $stockBatik->kode_batik . '.svg';
            return Storage::download('public/' . $stockBatik->qr_code, $downloadName);
        }
        Session::flash('error', 'QR Code tidak ditemukan.');
        return redirect()->back();
    }

    /**
     * Export stock batik data to Excel.
     * Mengunduh data stok batik ke file Excel.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function export()
    {
        try {
            // Memberikan nama file yang informatif
            $fileName = 'stock_batik_' . Carbon::now()->format('Ymd_His') . '.xlsx';
            
            // Menggunakan Laravel Excel untuk mengunduh koleksi data
            return Excel::download(new StockBatikExport, $fileName);
            
        } catch (\Exception $e) {
            Log::error('Gagal mengekspor data stok batik: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengekspor data stok batik: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}