<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_bahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bahan', 10)->unique(); // 001, 002, 003
            $table->string('nama_bahan');
            $table->string('satuan'); // meter, kg, pcs, dll
            $table->decimal('harga_satuan', 10, 2);
            $table->integer('qty_masuk');
            $table->integer('qty_tersedia');
            $table->integer('qty_terpakai')->default(0);
            $table->decimal('total_harga', 10, 2);
            $table->string('qr_code')->nullable();
            $table->date('tanggal_masuk');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_bahans');
    }
};