<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_nota', 15)->unique(); // NT250625001
            $table->foreignId('kasir_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_pembeli');
            $table->string('telepon_pembeli')->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->decimal('total_bayar', 10, 2);
            $table->decimal('kembalian', 10, 2)->default(0);
            $table->timestamp('tanggal_penjualan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};