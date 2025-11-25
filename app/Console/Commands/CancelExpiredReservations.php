<?php

namespace App\Console\Commands;

use App\Models\Reservasi;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CancelExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservasi:cancel-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel reservations that have exceeded their 24-hour payment deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired reservations...');

        // Find all pending reservations where payment_deadline has passed
        $expiredReservations = Reservasi::where('status_pembayaran', 'pending')
            ->where('payment_deadline', '<', now())
            ->get();

        if ($expiredReservations->isEmpty()) {
            $this->info('No expired reservations found.');
            return;
        }

        $count = $expiredReservations->count();
        $this->info("Found {$count} expired reservation(s). Cancelling...");

        foreach ($expiredReservations as $reservation) {
            $reservation->update(['status_pembayaran' => 'expired']);
            $this->line("Cancelled reservation: {$reservation->nomor_reservasi}");
        }

        $this->info("Successfully cancelled {$count} expired reservation(s).");
    }
}
