<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule; // Tambahkan ini
use App\Console\Commands\RemindUpcomingReservations; // Tambahkan ini (Pastikan Anda sudah membuat command ini dulu)
use App\Console\Commands\CancelExpiredReservations; // Tambahkan ini
use App\Console\Commands\SendPaymentReminders; // Tambahkan ini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // --- Bagian yang sudah ada sebelumnya ---
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckUserRole::class,
        ]);
        // --- Akhir bagian yang sudah ada sebelumnya ---
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) { // Tambahkan blok ini
        // Jadwalkan command untuk pengingat WhatsApp
        $schedule->command(RemindUpcomingReservations::class)->dailyAt('08:00');
        // Untuk pengujian cepat di local, Anda bisa gunakan hourly()
        // $schedule->command(RemindUpcomingReservations::class)->everyMinute(); // Lebih sering untuk testing
        
        // Jadwalkan command untuk membatalkan reservasi expired
        $schedule->command(CancelExpiredReservations::class)->hourly();

        // Jadwalkan command untuk mengirim pengingat pembayaran
        $schedule->command(SendPaymentReminders::class)->hourly();
    })
    ->withCommands([ // Tambahkan blok ini untuk mendaftarkan command
        RemindUpcomingReservations::class, // Daftarkan Command Anda di sini
        CancelExpiredReservations::class, // Daftarkan command cancel expired reservations
        SendPaymentReminders::class, // Daftarkan command send payment reminders
    ])
    ->create();