<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Reservasi;
use App\Models\PenggunaanBahan;
use App\Models\StockBahan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganExport;

class LaporanKeuanganController extends Controller
{
    /**
     * Display income report (Pemasukan)
     * Shows all revenue from workshops and product sales
     */
    public function pemasukan(Request $request)
    {
        $startDate = $request->input('tanggal_dari');
        $endDate = $request->input('tanggal_sampai');

        // Parse dates with default values
        $startDateParsed = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDateParsed = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        // --- Pemasukan dari Penjualan Produk Batik ---
        $penjualanBatik = Penjualan::whereBetween('tanggal_penjualan', [$startDateParsed, $endDateParsed])
            ->select(
                DB::raw("'Penjualan Produk' as kategori"),
                'tanggal_penjualan as tanggal',
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('tanggal_penjualan')
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        // --- Pemasukan dari Workshop (Reservasi yang sudah dibayar) ---
        $workshopIncome = Reservasi::with(['jadwalWorkshop.paketWorkshop'])
            ->where('status_pembayaran', 'paid')
            ->whereHas('jadwalWorkshop', function ($q) use ($startDateParsed, $endDateParsed) {
                $q->whereBetween('tanggal', [$startDateParsed, $endDateParsed]);
            })
            ->select(
                DB::raw("CONCAT('Workshop: ', paket_workshops.nama_paket) as kategori"),
                'reservasis.created_at as tanggal',
                DB::raw('1 as jumlah_transaksi'),
                'reservasis.total_harga as total'
            )
            ->join('jadwal_workshops', 'reservasis.jadwal_workshop_id', '=', 'jadwal_workshops.id')
            ->join('paket_workshops', 'jadwal_workshops.paket_workshop_id', '=', 'paket_workshops.id')
            ->orderBy('reservasis.created_at', 'desc')
            ->get();

        // Combine all income sources
        $allIncome = collect()
            ->merge($penjualanBatik->map(function ($item) {
                return [
                    'kategori' => $item->kategori,
                    'tanggal' => $item->tanggal,
                    'jumlah_transaksi' => $item->jumlah_transaksi,
                    'total' => $item->total,
                    'tipe' => 'penjualan'
                ];
            }))
            ->merge($workshopIncome->map(function ($item) {
                return [
                    'kategori' => $item->kategori,
                    'tanggal' => $item->tanggal,
                    'jumlah_transaksi' => $item->jumlah_transaksi,
                    'total' => $item->total,
                    'tipe' => 'workshop'
                ];
            }))
            ->sortByDesc('tanggal')
            ->values();

        // Calculate totals
        $totalPenjualan = $penjualanBatik->sum('total');
        $totalWorkshop = $workshopIncome->sum('total');
        $totalKeseluruhan = $totalPenjualan + $totalWorkshop;

        // Statistics
        $jumlahTransaksiPenjualan = $penjualanBatik->count();
        $jumlahTransaksiWorkshop = $workshopIncome->count();

        return view('admin.laporan_keuangan.pemasukan', [
            'allIncome' => $allIncome,
            'totalPenjualan' => $totalPenjualan,
            'totalWorkshop' => $totalWorkshop,
            'totalKeseluruhan' => $totalKeseluruhan,
            'jumlahTransaksiPenjualan' => $jumlahTransaksiPenjualan,
            'jumlahTransaksiWorkshop' => $jumlahTransaksiWorkshop,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'startDateParsed' => $startDateParsed,
            'endDateParsed' => $endDateParsed,
        ]);
    }

    /**
     * Display expense report (Pengeluaran)
     * Shows all costs from materials, tools, and operational expenses
     */
    public function pengeluaran(Request $request)
    {
        $startDate = $request->input('tanggal_dari');
        $endDate = $request->input('tanggal_sampai');

        // Parse dates with default values
        $startDateParsed = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDateParsed = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        // --- Pengeluaran dari Penggunaan Bahan ---
        $penggunaanBahan = PenggunaanBahan::with('stockBahan')
            ->whereBetween('tanggal_penggunaan', [$startDateParsed, $endDateParsed])
            ->select(
                DB::raw("CONCAT('Bahan: ', stock_bahans.nama_bahan) as kategori"),
                'penggunaan_bahans.tanggal_penggunaan as tanggal',
                'penggunaan_bahans.qty_digunakan as jumlah',
                DB::raw('penggunaan_bahans.qty_digunakan * stock_bahans.harga_satuan as total'),
                DB::raw("'bahan' as tipe")
            )
            ->join('stock_bahans', 'penggunaan_bahans.stock_bahan_id', '=', 'stock_bahans.id')
            ->orderBy('penggunaan_bahans.tanggal_penggunaan', 'desc')
            ->get();

        // Grouping expense by date and category
        $allExpenses = $penggunaanBahan->map(function ($item) {
            return [
                'kategori' => $item->kategori,
                'tanggal' => $item->tanggal,
                'jumlah' => $item->jumlah,
                'total' => $item->total,
                'tipe' => 'bahan'
            ];
        })->sortByDesc('tanggal')->values();

        // Calculate totals
        $totalPenggunaanBahan = $penggunaanBahan->sum('total');

        // Summary by category
        $expensesByCategory = $penggunaanBahan->groupBy('kategori')
            ->map(function ($items) {
                return [
                    'kategori' => $items->first()['kategori'],
                    'total' => $items->sum('total'),
                    'jumlah_item' => $items->count()
                ];
            })
            ->values();

        return view('admin.laporan_keuangan.pengeluaran', [
            'allExpenses' => $allExpenses,
            'expensesByCategory' => $expensesByCategory,
            'totalPenggunaanBahan' => $totalPenggunaanBahan,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'startDateParsed' => $startDateParsed,
            'endDateParsed' => $endDateParsed,
        ]);
    }

    /**
     * Export income report to Excel
     */
    public function exportPemasukan(Request $request)
    {
        $startDate = $request->input('tanggal_dari');
        $endDate = $request->input('tanggal_sampai');

        $startDateParsed = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDateParsed = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        $fileName = 'Laporan_Pemasukan_' . $startDateParsed->format('d-m-Y') . '_sampai_' . $endDateParsed->format('d-m-Y') . '.xlsx';

        return Excel::download(
            new LaporanKeuanganExport('pemasukan', $startDateParsed, $endDateParsed),
            $fileName
        );
    }

    /**
     * Export expense report to Excel
     */
    public function exportPengeluaran(Request $request)
    {
        $startDate = $request->input('tanggal_dari');
        $endDate = $request->input('tanggal_sampai');

        $startDateParsed = $startDate ? Carbon::parse($startDate)->startOfDay() : Carbon::now()->startOfMonth()->startOfDay();
        $endDateParsed = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        $fileName = 'Laporan_Pengeluaran_' . $startDateParsed->format('d-m-Y') . '_sampai_' . $endDateParsed->format('d-m-Y') . '.xlsx';

        return Excel::download(
            new LaporanKeuanganExport('pengeluaran', $startDateParsed, $endDateParsed),
            $fileName
        );
    }
}
