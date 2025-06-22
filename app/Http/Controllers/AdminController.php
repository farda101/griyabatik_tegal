<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Reservasi;
use App\Models\StockBatik;
use App\Models\StockBahan;
use App\Models\User;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; // Pastikan Session diimport
use Illuminate\Support\Facades\Log;

use App\Exports\PenjualanReportExport; // Tambahkan ini
use Maatwebsite\Excel\Facades\Excel; // Tambahkan ini

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with reporting and analytics.
     */
    public function index()
    {
        // --- Statistik Penjualan ---
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        $totalPenjualanHariIni = Penjualan::whereDate('tanggal_penjualan', $today)->sum('total_harga');
        $jumlahTransaksiHariIni = Penjualan::whereDate('tanggal_penjualan', $today)->count();
        
        $totalPenjualanBulanIni = Penjualan::whereMonth('tanggal_penjualan', $thisMonth->month)
                                        ->whereYear('tanggal_penjualan', $thisMonth->year)
                                        ->sum('total_harga');
        $jumlahTransaksiBulanIni = Penjualan::whereMonth('tanggal_penjualan', $thisMonth->month)
                                        ->whereYear('tanggal_penjualan', $thisMonth->year)
                                        ->count();
        
        $totalPenjualanKeseluruhan = Penjualan::sum('total_harga');
        $jumlahTransaksiKeseluruhan = Penjualan::count();

        // --- Statistik Reservasi ---
        $totalReservasiHariIni = Reservasi::whereHas('jadwalWorkshop', function($q) use ($today) {
                                        $q->whereDate('tanggal', $today);
                                    })->count();
        $totalReservasiPending = Reservasi::where('status_pembayaran', 'pending')->count();
        $totalReservasiPaid = Reservasi::where('status_pembayaran', 'paid')->count();
        $totalReservasiExpired = Reservasi::where('status_pembayaran', 'expired')->count();
        $totalReservasiKeseluruhan = Reservasi::count();

        // --- Statistik Stok ---
        $totalBatikTersedia = StockBatik::sum('qty_tersedia');
        $jumlahJenisBatikStokRendah = StockBatik::lowStock()->count();
        $totalNilaiBatikTersedia = StockBatik::sum(DB::raw('qty_tersedia * harga_jual'));

        $totalBahanTersedia = StockBahan::sum('qty_tersedia');
        $jumlahJenisBahanStokRendah = StockBahan::lowStock()->count();
        $totalNilaiBahanTersedia = StockBahan::sum(DB::raw('qty_tersedia * harga_satuan'));

        // Ambil nilai minimum alert dari Settings
        $minStockAlertBatik = Setting::get('min_stock_alert', 5);
        $minStockAlertBahan = Setting::get('min_stock_alert_bahan', 10);


        return view('admin.dashboard', compact(
            'totalPenjualanHariIni',
            'totalPenjualanBulanIni',
            'totalPenjualanKeseluruhan',
            'jumlahTransaksiHariIni',
            'jumlahTransaksiBulanIni',
            'jumlahTransaksiKeseluruhan',
            'totalReservasiHariIni',
            'totalReservasiPending',
            'totalReservasiPaid',
            'totalReservasiExpired',
            'totalReservasiKeseluruhan',
            'totalBatikTersedia',
            'jumlahJenisBatikStokRendah',
            'totalNilaiBatikTersedia',
            'totalBahanTersedia',
            'jumlahJenisBahanStokRendah',
            'totalNilaiBahanTersedia',
            'minStockAlertBatik',
            'minStockAlertBahan'
        ));
    }

    /**
     * Export a sales report to Excel.
     * Mengunduh laporan penjualan ke file Excel, dengan opsi filter tanggal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function exportPenjualanReport(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $fileName = 'laporan_penjualan';
            if ($startDate && $endDate) {
                $fileName .= '_' . Carbon::parse($startDate)->format('Ymd') . '_sd_' . Carbon::parse($endDate)->format('Ymd');
            } elseif ($startDate) {
                $fileName .= '_dari_' . Carbon::parse($startDate)->format('Ymd');
            } elseif ($endDate) {
                $fileName .= '_sampai_' . Carbon::parse($endDate)->format('Ymd');
            }
            $fileName .= '_' . Carbon::now()->format('His') . '.xlsx';

            return Excel::download(new PenjualanReportExport($startDate, $endDate), $fileName);

        } catch (\Exception $e) {
            Log::error('Gagal mengekspor laporan penjualan: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengekspor laporan penjualan: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}