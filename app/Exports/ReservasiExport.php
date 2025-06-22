<?php

namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon; // Pastikan Carbon diimport

class ReservasiExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil semua data Reservasi yang ingin diekspor
        // Eager load relasi 'jadwalWorkshop' dan 'paketWorkshop' untuk mendapatkan detail yang lengkap
        return Reservasi::with(['jadwalWorkshop', 'jadwalWorkshop.paketWorkshop'])->get();
    }

    /**
     * Menambahkan baris judul (headings) di bagian paling atas file Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID Reservasi',
            'Nomor Reservasi',
            'Paket Workshop',
            'Tanggal Workshop',
            'Jam Mulai',
            'Jam Selesai',
            'Jenis Peserta',
            'Jumlah Peserta',
            'Total Harga',
            'Nama Pemesan',
            'Email Pemesan',
            'Telepon Pemesan',
            'Alamat Pemesan',
            'Status Pembayaran',
            'Midtrans Transaction ID',
            'Paid At',
            'Reminder Sent',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }

    /**
     * Memetakan setiap baris data dari collection ke format yang akan diekspor.
     * @param mixed $reservasi
     * @return array
     */
    public function map($reservasi): array
    {
        $paketWorkshopName = $reservasi->jadwalWorkshop->paketWorkshop->nama_paket ?? 'N/A';
        $jadwalTanggal = $reservasi->jadwalWorkshop->tanggal->format('Y-m-d') ?? 'N/A';
        $jadwalJamMulai = $reservasi->jadwalWorkshop->jam_mulai->format('H:i') ?? 'N/A';
        $jadwalJamSelesai = $reservasi->jadwalWorkshop->jam_selesai->format('H:i') ?? 'N/A';

        return [
            $reservasi->id,
            $reservasi->nomor_reservasi,
            $paketWorkshopName,
            $jadwalTanggal,
            $jadwalJamMulai,
            $jadwalJamSelesai,
            ucfirst($reservasi->jenis_peserta),
            $reservasi->jumlah_peserta,
            number_format($reservasi->total_harga, 0, ',', '.'),
            $reservasi->nama_pemesan,
            $reservasi->email_pemesan,
            $reservasi->telepon_pemesan,
            $reservasi->alamat_pemesan ?? '-',
            ucfirst($reservasi->status_pembayaran),
            $reservasi->midtrans_transaction_id ?? '-',
            $reservasi->paid_at ? $reservasi->paid_at->format('Y-m-d H:i:s') : '-',
            $reservasi->reminder_sent ? 'Ya' : 'Tidak',
            $reservasi->created_at->format('Y-m-d H:i:s'),
            $reservasi->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}