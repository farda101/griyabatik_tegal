<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservasi;
use App\Jobs\SendWhatsAppNotification; // Import Job
use Carbon\Carbon; // Import Carbon
use Illuminate\Support\Facades\Log; // Import Log

class RemindUpcomingReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp reminders for upcoming workshops (H-1).';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Perbaikan: Gunakan Carbon::today() lalu addDays(1) untuk besok.
        // Carbon::tomorrow() sudah cukup
        $tomorrow = Carbon::tomorrow()->toDateString();

        $this->info("Mencari reservasi untuk pengingat H-1 pada tanggal {$tomorrow}...");

        // Cari reservasi yang statusnya PAID, belum dikirim pengingat, dan jadwalnya besok
        $reservationsToRemind = Reservasi::with('jadwalWorkshop.paketWorkshop')
                                    ->paid()
                                    ->where('reminder_sent', false)
                                    ->whereHas('jadwalWorkshop', function($query) use ($tomorrow) {
                                        $query->whereDate('tanggal', $tomorrow);
                                    })
                                    ->get();

        $this->info("Ditemukan " . $reservationsToRemind->count() . " reservasi untuk pengingat besok.");

        foreach ($reservationsToRemind as $reservasi) {
            if ($reservasi->jadwalWorkshop && $reservasi->jadwalWorkshop->paketWorkshop) {
                $phoneNumberClean = ltrim($reservasi->telepon_pemesan, '+'); // Hapus '+' jika ada
                $message = "Halo {$reservasi->nama_pemesan},\n\nIni adalah pengingat untuk reservasi workshop '{$reservasi->jadwalWorkshop->paketWorkshop->nama_paket}' Anda besok, tanggal {$reservasi->jadwalWorkshop->tanggal->format('d M Y')} pukul {$reservasi->jadwalWorkshop->jam_mulai->format('H:i')}.\n\nMohon hadir tepat waktu. Terima kasih!\nWorkshop Batik Tegalan";

                // Dispatch Job untuk mengirim notifikasi
                SendWhatsAppNotification::dispatch($phoneNumberClean, $message, $reservasi->id);
                $this->info("Notifikasi pengingat berhasil dikirim untuk reservasi: {$reservasi->nomor_reservasi}.");
            } else {
                $this->warn("Melewatkan pengingat untuk reservasi: {$reservasi->nomor_reservasi} karena data jadwal/paket tidak lengkap.");
            }
        }

        $this->info("Proses pengiriman pengingat selesai.");
    }
}