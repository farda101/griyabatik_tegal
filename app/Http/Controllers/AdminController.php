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
    public function index(Request $request)
    {
        // Get date filters from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Parse dates if provided
        $startDateParsed = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $endDateParsed = $endDate ? Carbon::parse($endDate)->endOfDay() : null;

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
        $totalReservasiHariIni = Reservasi::whereHas('jadwalWorkshop', function ($q) use ($today) {
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

        // --- Data untuk Chart Penjualan Bulanan (12 bulan terakhir atau berdasarkan filter) ---
        $monthlySales = [];
        $monthlyLabels = [];
        if ($startDateParsed && $endDateParsed) {
            // Jika ada filter tanggal, gunakan rentang tersebut
            $startMonth = $startDateParsed->copy()->startOfMonth();
            $endMonth = $endDateParsed->copy()->endOfMonth();
            $currentMonth = $startMonth->copy();
            
            while ($currentMonth <= $endMonth) {
                $monthlyLabels[] = $currentMonth->format('M Y');
                $monthlySales[] = Penjualan::whereBetween('tanggal_penjualan', [
                    $currentMonth->copy()->startOfMonth(),
                    $currentMonth->copy()->endOfMonth()
                ])->sum('total_harga');
                $currentMonth->addMonth();
            }
        } else {
            // Default: 12 bulan terakhir
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthlyLabels[] = $date->format('M Y');
                $monthlySales[] = Penjualan::whereMonth('tanggal_penjualan', $date->month)
                    ->whereYear('tanggal_penjualan', $date->year)
                    ->sum('total_harga');
            }
        }

        // --- Data untuk Chart Status Reservasi ---
        $reservationStatuses = [
            'pending' => Reservasi::where('status_pembayaran', 'pending')->count(),
            'paid' => Reservasi::where('status_pembayaran', 'paid')->count(),
            'failed' => Reservasi::where('status_pembayaran', 'failed')->count(),
            'expired' => Reservasi::where('status_pembayaran', 'expired')->count(),
        ];

        // --- Data untuk Chart Penjualan Harian (7 hari terakhir atau berdasarkan filter) ---
        $dailySales = [];
        $dailyLabels = [];
        if ($startDateParsed && $endDateParsed) {
            // Jika ada filter tanggal, gunakan rentang tersebut (max 30 hari untuk performa)
            $startDay = $startDateParsed->copy();
            $endDay = $endDateParsed->copy();
            $daysDiff = $startDay->diffInDays($endDay);
            
            if ($daysDiff > 30) {
                // Jika lebih dari 30 hari, batasi ke 30 hari terakhir dari end_date
                $startDay = $endDay->copy()->subDays(29);
            }
            
            $currentDay = $startDay->copy();
            while ($currentDay <= $endDay) {
                $dailyLabels[] = $currentDay->format('d M');
                $dailySales[] = Penjualan::whereDate('tanggal_penjualan', $currentDay)->sum('total_harga');
                $currentDay->addDay();
            }
        } else {
            // Default: 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dailyLabels[] = $date->format('d M');
                $dailySales[] = Penjualan::whereDate('tanggal_penjualan', $date)->sum('total_harga');
            }
        }

        // --- Laporan Singkat: Aktivitas Terbaru ---
        $recentReservations = Reservasi::with('jadwalWorkshop.paketWorkshop')
            ->latest()
            ->take(5)
            ->get();

        $recentSales = Penjualan::with('detailPenjualans.stockBatik')
            ->latest()
            ->take(5)
            ->get();

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
            'minStockAlertBahan',
            'monthlySales',
            'monthlyLabels',
            'reservationStatuses',
            'dailySales',
            'dailyLabels',
            'recentReservations',
            'recentSales'
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
            // Ambil start_date dan end_date dari request
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Tentukan nama file dengan tanggal
            $fileName = 'laporan_penjualan';

            if ($startDate && $endDate) {
                // Jika ada start_date dan end_date, format nama file dengan rentang tanggal
                $fileName .= '_' . Carbon::parse($startDate)->format('Ymd') . '_sd_' . Carbon::parse($endDate)->format('Ymd');
            } elseif ($startDate) {
                // Jika hanya ada start_date, format nama file dengan start_date
                $fileName .= '_dari_' . Carbon::parse($startDate)->format('Ymd');
            } elseif ($endDate) {
                // Jika hanya ada end_date, format nama file dengan end_date
                $fileName .= '_sampai_' . Carbon::parse($endDate)->format('Ymd');
            }

            // Tambahkan waktu untuk membedakan file yang diekspor
            $fileName .= '_' . Carbon::now()->format('His') . '.xlsx';

            // Jika tidak ada tanggal yang dipassing, ambil seluruh data penjualan
            if (!$startDate && !$endDate) {
                $startDate = null;
                $endDate = null;
            }

            // Menggunakan PenjualanReportExport untuk mengekspor laporan
            return Excel::download(new PenjualanReportExport($startDate, $endDate), $fileName);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, log error dan tampilkan pesan kesalahan
            Log::error('Gagal mengekspor laporan penjualan: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengekspor laporan penjualan: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Export statistics data to Excel.
     */
    public function exportStatistics(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $fileName = 'statistik_dashboard';

            if ($startDate && $endDate) {
                $fileName .= '_' . Carbon::parse($startDate)->format('Ymd') . '_sd_' . Carbon::parse($endDate)->format('Ymd');
            } elseif ($startDate) {
                $fileName .= '_dari_' . Carbon::parse($startDate)->format('Ymd');
            } elseif ($endDate) {
                $fileName .= '_sampai_' . Carbon::parse($endDate)->format('Ymd');
            }

            $fileName .= '_' . Carbon::now()->format('His') . '.xlsx';

            return Excel::download(new StatisticsExport($startDate, $endDate), $fileName);
        } catch (\Exception $e) {
            Log::error('Gagal mengekspor statistik: ' . $e->getMessage(), ['exception' => $e]);
            Session::flash('error', 'Terjadi kesalahan saat mengekspor statistik: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
