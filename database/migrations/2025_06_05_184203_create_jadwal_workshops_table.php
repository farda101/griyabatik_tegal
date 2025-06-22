<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_workshops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_workshop_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('max_peserta');
            $table->integer('peserta_terdaftar')->default(0);
            $table->enum('status', ['available', 'unavailable', 'full'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_workshops');
    }
};