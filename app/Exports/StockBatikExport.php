<?php

namespace App\Exports;

use App\Models\StockBatik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Tambahkan ini untuk header kolom
use Maatwebsite\Excel\Concerns\WithMapping;  // Tambahkan ini untuk memformat data

class StockBatikExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil semua data StockBatik yang ingin diekspor
        // Eager load relasi 'pengrajin' untuk mendapatkan nama pengrajin
        return StockBatik::with('pengrajin')->get();
    }

    /**
     * Menambahkan baris judul (headings) di bagian paling atas file Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Kode Batik',
            'Nama Batik',
            'Pengrajin (Kode)',
            'Pengrajin (Nama)',
            'Motif',
            'Ukuran',
            'Harga Beli',
            'Harga Jual',
            'Margin (Rp)',
            'Margin (%)',
            'Qty Masuk',
            'Qty Tersedia',
            'Qty Terjual',
            'Tanggal Masuk',
            'QR Code Path',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Memetakan setiap baris data dari collection ke format yang akan diekspor.
     * Digunakan untuk memformat data atau mengambil data dari relasi.
     * @param mixed $batik
     * @return array
     */
    public function map($batik): array
    {
        return [
            $batik->id,
            $batik->kode_batik,
            $batik->nama_batik,
            $batik->pengrajin->kode_pengrajin ?? 'N/A', // Ambil kode pengrajin
            $batik->pengrajin->nama_pengrajin ?? 'N/A', // Ambil nama pengrajin
            $batik->motif ?? '-',
            $batik->ukuran ?? '-',
            number_format($batik->harga_beli, 0, ',', '.'), // Format harga
            number_format($batik->harga_jual, 0, ',', '.'), // Format harga
            number_format($batik->margin, 0, ',', '.'), // Accessor dari model
            $batik->margin_persentase . '%', // Accessor dari model
            $batik->qty_masuk,
            $batik->qty_tersedia,
            $batik->qty_terjual,
            $batik->tanggal_masuk->format('Y-m-d'), // Format tanggal
            $batik->qr_code ?? '-',
            $batik->created_at->format('Y-m-d H:i:s'),
            $batik->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}