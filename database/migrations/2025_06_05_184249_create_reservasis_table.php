<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_reservasi', 15)->unique(); // RSV250625001
            $table->foreignId('jadwal_workshop_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_peserta', ['individu', 'kelompok']);
            $table->integer('jumlah_peserta');
            $table->string('nama_pemesan');
            $table->string('email_pemesan');
            $table->string('telepon_pemesan');
            $table->text('alamat_pemesan')->nullable();
            $table->string('file_permohonan')->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->string('midtrans_transaction_id')->nullable();
            $table->text('midtrans_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservasis');
    }
};