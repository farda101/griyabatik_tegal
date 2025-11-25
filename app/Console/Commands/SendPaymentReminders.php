<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservasi;
use App\Mail\PaymentReminder;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment reminders to users with pending reservations approaching deadline';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find pending reservations where payment_deadline is within 1 hour and reminder not sent
        $reservations = Reservasi::where('status_pembayaran', 'pending')
            ->where('payment_deadline', '>', now())
            ->where('payment_deadline', '<=', now()->addHour())
            ->where('reminder_sent', false)
            ->get();

        $this->info("Found {$reservations->count()} reservations to send reminders to.");

        foreach ($reservations as $reservasi) {
            try {
                Mail::to($reservasi->email_pemesan)->send(new PaymentReminder($reservasi));

                // Mark reminder as sent
                $reservasi->update(['reminder_sent' => true]);

                $this->info("Reminder sent to {$reservasi->email_pemesan} for reservation {$reservasi->nomor_reservasi}");
            } catch (\Exception $e) {
                $this->error("Failed to send reminder to {$reservasi->email_pemesan}: {$e->getMessage()}");
            }
        }

        $this->info('Payment reminders sent successfully.');
    }
}
