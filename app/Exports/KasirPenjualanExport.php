<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk mendapatkan ID kasir

class KasirPenjualanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $kasirId;

    public function __construct(string $startDate = null, string $endDate = null, int $kasirId)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
        $this->kasirId = $kasirId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Penjualan::with(['kasir', 'detailPenjualans.stockBatik'])
                            ->where('kasir_id', $this->kasirId); // Filter berdasarkan ID kasir

        if ($this->startDate) {
            $query->whereDate('tanggal_penjualan', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('tanggal_penjualan', '<=', $this->endDate);
        }

        return $query->latest('tanggal_penjualan')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Penjualan',
            'Nomor Nota',
            'Tanggal Penjualan',
            'Kasir',
            'Nama Pembeli',
            'Telepon Pembeli',
            'Total Harga',
            'Total Dibayar',
            'Kembalian',
            'Detail Item', // Kolom untuk detail item
            'Harga Pokok',
            'Keuntungan',
        ];
    }

    /**
     * @param mixed $penjualan
     * @return array
     */
    public function map($penjualan): array
    {
        $itemDetails = [];
        $totalHargaPokok = 0;
        $totalKeuntungan = 0;

        foreach ($penjualan->detailPenjualans as $detail) {
            $itemName = $detail->stockBatik->nama_batik ?? 'N/A';
            $itemCode = $detail->stockBatik->kode_batik ?? 'N/A';
            $hargaBeliItem = $detail->stockBatik->harga_beli ?? 0;
            $keuntunganItem = ($detail->harga_satuan - $hargaBeliItem) * $detail->qty;

            $itemDetails[] = "{$itemName} ({$itemCode}) x{$detail->qty} @Rp" . number_format($detail->harga_satuan, 0, ',', '.') . " = Rp" . number_format($detail->subtotal, 0, ',', '.');
            $totalHargaPokok += $hargaBeliItem * $detail->qty;
            $totalKeuntungan += $keuntunganItem;
        }

        return [
            $penjualan->id,
            $penjualan->nomor_nota,
            $penjualan->tanggal_penjualan->format('Y-m-d H:i:s'),
            $penjualan->kasir->name ?? 'N/A',
            $penjualan->nama_pembeli,
            $penjualan->telepon_pembeli ?? '-',
            number_format($penjualan->total_harga, 0, ',', '.'),
            number_format($penjualan->total_bayar, 0, ',', '.'),
            number_format($penjualan->kembalian, 0, ',', '.'),
            implode("\n", $itemDetails),
            number_format($totalHargaPokok, 0, ',', '.'),
            number_format($totalKeuntungan, 0, ',', '.'),
        ];
    }
}