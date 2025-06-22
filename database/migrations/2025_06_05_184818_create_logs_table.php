    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
                $table->string('action'); // create, update, delete, login, etc
                $table->string('model'); // Stock, Reservasi, dll
                $table->unsignedBigInteger('model_id')->nullable();
                $table->json('old_data')->nullable();
                $table->json('new_data')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('logs');
        }
    };