<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // whatsapp, email, system
            $table->string('title');
            $table->text('message');
            $table->string('recipient'); // phone/email
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->json('data')->nullable(); // additional data
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};