<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config; // Import Midtrans Config

class MidtransServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default: true)
        Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default: false)
        Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS authentication for credit card (default: false)
        Config::$is3ds = config('midtrans.is_3ds');
    }
}