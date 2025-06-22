<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\WhatsAppService; // Import service yang baru kita buat
use App\Models\Reservasi; // Jika Anda perlu mengupdate model reservasi setelah kirim notif
use Illuminate\Support\Facades\Log; // Tambahkan ini

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumber;
    protected $message;
    protected $reservasiId; // Opsional: untuk update status reminder_sent

    /**
     * Create a new job instance.
     *
     * @param string $phoneNumber Nomor telepon tujuan (misal: 628123456789)
     * @param string $message Isi pesan
     * @param int|null $reservasiId ID reservasi (opsional)
     */
    public function __construct(string $phoneNumber, string $message, ?int $reservasiId = null)
    {
        $this->phoneNumber = $phoneNumber;
        $this->message = $message;
        $this->reservasiId = $reservasiId;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        Log::info("Mencoba mengirim notifikasi WhatsApp ke {$this->phoneNumber} untuk reservasi ID {$this->reservasiId}.");
        $success = $whatsAppService->sendMessage($this->phoneNumber, $this->message);

        if ($success && $this->reservasiId) {
            // Jika notifikasi berhasil dikirim, tandai di database reservasi
            $reservasi = Reservasi::find($this->reservasiId);
            if ($reservasi) {
                $reservasi->update(['reminder_sent' => true]);
                Log::info("Status reminder_sent untuk reservasi ID {$this->reservasiId} diubah menjadi true.");
            } else {
                Log::warning("Reservasi ID {$this->reservasiId} tidak ditemukan saat mencoba update reminder_sent.");
            }
        } else if (!$success) {
            Log::error("Gagal mengirim notifikasi WhatsApp untuk reservasi ID {$this->reservasiId}.");
        }
    }
}