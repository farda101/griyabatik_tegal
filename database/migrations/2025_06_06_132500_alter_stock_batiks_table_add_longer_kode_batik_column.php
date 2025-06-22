<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stock_batiks', function (Blueprint $table) {
            // Ubah kolom kode_batik menjadi panjang 25 karakter
            // Pastikan ini diletakkan SETELAH definisi kolom kode_batik awal di migrasi sebelumnya.
            $table->string('kode_batik', 25)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_batiks', function (Blueprint $table) {
            // Kembalikan ke panjang semula jika diperlukan, atau ke panjang default string jika tidak ada batas
            $table->string('kode_batik', 15)->change();
        });
    }
};