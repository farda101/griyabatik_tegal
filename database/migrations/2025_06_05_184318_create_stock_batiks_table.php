<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_batiks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_batik', 15)->unique(); // 9902062501
            $table->foreignId('pengrajin_id')->constrained()->onDelete('cascade');
            $table->string('nama_batik');
            $table->text('deskripsi')->nullable();
            $table->string('motif')->nullable();
            $table->string('ukuran')->nullable();
            $table->decimal('harga_beli', 10, 2);
            $table->decimal('harga_jual', 10, 2);
            $table->integer('qty_masuk');
            $table->integer('qty_tersedia');
            $table->integer('qty_terjual')->default(0);
            $table->string('qr_code')->nullable();
            $table->date('tanggal_masuk');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_batiks');
    }
};