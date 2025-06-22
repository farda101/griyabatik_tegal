<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\StockBatik;
use App\Models\Reservasi;
use App\Models\JadwalWorkshop;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KasirPenjualanExport;
use App\Exports\KasirReservasiExport; // Ini nanti akan kita buat
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
{
    /**
     * Menampilkan dashboard khusus untuk Kasir.
     * Ini bisa menjadi ringkasan singkat penjualan atau reservasi hari ini.
     */
    public function dashboardKasirIndex()
    {
        $today = Carbon::today();
        $kasirId = Auth::id();

        // Statistik Penjualan Kasir Hari Ini
        $totalPenjualanHariIniKasir = Penjualan::whereDate('tanggal_penjualan', $today)
                                            ->where('kasir_id', $kasirId)
                                            ->sum('total_harga');
        $jumlahTransaksiHariIniKasir = Penjualan::whereDate('tanggal_penjualan', $today)
                                            ->where('kasir_id', $kasirId)
                                            ->count();

        // Statistik Reservasi yang Pembayarannya Lunas Hari Ini (relevan untuk Kasir)
        $totalReservasiLunasHariIni = Reservasi::whereDate('paid_at', $today)
                                            ->where('status_pembayaran', 'paid')
                                            ->count();
        // Atau reservasi yang jadwalnya hari ini
        $totalReservasiJadwalHariIni = Reservasi::whereHas('jadwalWorkshop', function($q) use ($today) {
                                            $q->whereDate('tanggal', $today);
                                        })
                                        ->whereIn('status_pembayaran', ['paid', 'pending']) // Kasir mungkin perlu lihat pending juga
                                        ->count();

        // Stok Batik rendah (ringkasan)
        $jumlahJenisBatikStokRendah = StockBatik::lowStock()->count();

        return view('kasir.dashboard', compact(
            'totalPenjualanHariIniKasir',
            'jumlahTransaksiHariIniKasir',
            'totalReservasiLunasHariIni',
            'totalReservasiJadwalHariIni',
            'jumlahJenisBatikStokRendah'
        ));
    }

    /**
     * Menampilkan laporan penjualan yang dicatat oleh kasir yang sedang login.
     */
    public function penjualanIndex(Request $request)
    {
        $kasirId = Auth::id();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Penjualan::with(['kasir', 'detailPenjualans.stockBatik'])
                            ->where('kasir_id', $kasirId);

        if ($startDate) {
            $query->whereDate('tanggal_penjualan', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal_penjualan', '<=', $endDate);
        }

        $penjualans = $query->latest('tanggal_penjualan')->paginate(10);

        return view('kasir.laporan.penjualan', compact('penjualans', 'startDate', 'endDate'));
    }

    /**
     * Export laporan penjualan kasir ke Excel.
     */
    public function exportPenjualan(Request $request)
    {
        $kasirId = Auth::id();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        try {
            $fileName = 'laporan_penjualan_kasir_' . Auth::user()->name . '_' . Carbon::now()->format('Ymd_His') . '.xlsx';
            
            return Excel::download(new KasirPenjualanExport($startDate, $endDate, $kasirId), $fileName);

        } catch (\Exception $e) {
            Log::error('Gagal mengekspor laporan penjualan kasir: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengekspor laporan penjualan: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Menampilkan detail penjualan tertentu untuk kasir.
     *
     * @param  \App\Models\Penjualan  $penjualan
     */
    public function penjualanShow(Penjualan $penjualan)
    {
        // Pastikan kasir yang sedang login adalah kasir yang melakukan penjualan ini
        // Atau superadmin
        if (Auth::user()->id !== $penjualan->kasir_id && !Auth::user()->isSuperadmin) {
            abort(403, 'Anda tidak memiliki izin untuk melihat detail penjualan ini.');
        }

        // Eager load relasi untuk detail tampilan
        $penjualan->load(['kasir', 'detailPenjualans.stockBatik.pengrajin']); // Load pengrajin batik juga
        return view('kasir.laporan.penjualan-detail', compact('penjualan'));
    }

    /**
     * Menampilkan laporan stok batik yang tersedia.
     */
    public function stokIndex()
    {
        $stoks = StockBatik::orderBy('nama_batik')->get();

        return view('kasir.laporan.stok', compact('stoks'));
    }

    /**
     * Menampilkan laporan reservasi yang relevan untuk kasir.
     */
    public function reservasiIndex(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $filterDate = $request->input('date', $today);
        $filterStatus = $request->input('status', 'all');

        $query = Reservasi::with(['jadwalWorkshop', 'jadwalWorkshop.paketWorkshop'])
                            ->whereHas('jadwalWorkshop', function($q) use ($filterDate) {
                                $q->whereDate('tanggal', $filterDate);
                            });

        if ($filterStatus !== 'all') {
            $query->where('status_pembayaran', $filterStatus);
        }

        $reservasis = $query->latest('created_at')->paginate(10);

        return view('kasir.laporan.reservasi', compact('reservasis', 'filterDate', 'filterStatus'));
    }
}