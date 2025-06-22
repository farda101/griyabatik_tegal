<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penggunaan_bahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_bahan_id')->constrained()->onDelete('cascade');
            $table->integer('qty_digunakan');
            $table->string('keperluan'); // produksi, workshop, dll
            $table->text('keterangan')->nullable();
            $table->date('tanggal_penggunaan');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // yang input
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penggunaan_bahans');
    }
};