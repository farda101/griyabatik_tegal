<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengrajins', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengrajin', 4)->unique(); // 9902
            $table->string('nama_pengrajin');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengrajins');
    }
};