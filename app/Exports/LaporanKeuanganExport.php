<?php

namespace App\Exports;

use App\Models\Penjualan;
use App\Models\Reservasi;
use App\Models\PenggunaanBahan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanKeuanganExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $type; // 'pemasukan' or 'pengeluaran'
    protected $startDate;
    protected $endDate;

    public function __construct($type, $startDate, $endDate)
    {
        $this->type = $type;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        if ($this->type === 'pemasukan') {
            return $this->getPemasukanData();
        } else {
            return $this->getPengeluaranData();
        }
    }

    protected function getPemasukanData()
    {
        // Get sales data
        $penjualan = Penjualan::whereBetween('tanggal_penjualan', [$this->startDate, $this->endDate])
            ->select(
                DB::raw("'Penjualan Produk' as kategori"),
                'tanggal_penjualan as tanggal',
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(total_harga) as total')
            )
            ->groupBy('tanggal_penjualan')
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        // Get workshop income
        $workshop = Reservasi::with(['jadwalWorkshop.paketWorkshop'])
            ->where('status_pembayaran', 'paid')
            ->whereHas('jadwalWorkshop', function ($q) {
                $q->whereBetween('tanggal', [$this->startDate, $this->endDate]);
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

        $data = collect();

        // Add sales data
        foreach ($penjualan as $p) {
            $data->push([
                'Tanggal' => $p->tanggal,
                'Kategori' => $p->kategori,
                'Jumlah Transaksi' => $p->jumlah_transaksi,
                'Total (Rp)' => $p->total,
            ]);
        }

        // Add workshop data
        foreach ($workshop as $w) {
            $data->push([
                'Tanggal' => $w->tanggal,
                'Kategori' => $w->kategori,
                'Jumlah Transaksi' => $w->jumlah_transaksi,
                'Total (Rp)' => $w->total,
            ]);
        }

        // Add summary row
        $totalPenjualan = $penjualan->sum('total');
        $totalWorkshop = $workshop->sum('total');

        $data->push([
            'Tanggal' => '',
            'Kategori' => 'TOTAL PEMASUKAN',
            'Jumlah Transaksi' => '',
            'Total (Rp)' => $totalPenjualan + $totalWorkshop,
        ]);

        return $data;
    }

    protected function getPengeluaranData()
    {
        $expenses = PenggunaanBahan::with('stockBahan')
            ->whereBetween('tanggal_penggunaan', [$this->startDate, $this->endDate])
            ->select(
                'penggunaan_bahans.tanggal_penggunaan as tanggal',
                DB::raw("CONCAT('Bahan: ', stock_bahans.nama_bahan) as kategori"),
                'penggunaan_bahans.qty_digunakan as jumlah',
                DB::raw('penggunaan_bahans.qty_digunakan * stock_bahans.harga_satuan as total')
            )
            ->join('stock_bahans', 'penggunaan_bahans.stock_bahan_id', '=', 'stock_bahans.id')
            ->orderBy('penggunaan_bahans.tanggal_penggunaan', 'desc')
            ->get();

        $data = collect();

        foreach ($expenses as $e) {
            $data->push([
                'Tanggal' => $e->tanggal,
                'Kategori' => $e->kategori,
                'Jumlah' => $e->jumlah,
                'Total (Rp)' => $e->total,
            ]);
        }

        // Add summary row
        $totalExpenses = $expenses->sum('total');

        $data->push([
            'Tanggal' => '',
            'Kategori' => 'TOTAL PENGELUARAN',
            'Jumlah' => '',
            'Total (Rp)' => $totalExpenses,
        ]);

        return $data;
    }

    public function headings(): array
    {
        if ($this->type === 'pemasukan') {
            return ['Tanggal', 'Kategori', 'Jumlah Transaksi', 'Total (Rp)'];
        } else {
            return ['Tanggal', 'Kategori', 'Jumlah', 'Total (Rp)'];
        }
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('4472C4');
        $sheet->getStyle('1')->getFont()->setColor(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        // Style last row (summary)
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle($lastRow)->getFont()->setBold(true);
        $sheet->getStyle($lastRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('D9E1F2');

        // Format currency columns
        $sheet->getStyle('D:D')->getNumberFormat()->setFormatCode('#,##0');

        return [];
    }
}
