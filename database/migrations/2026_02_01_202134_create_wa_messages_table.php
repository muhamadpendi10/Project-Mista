<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wa_messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('upload_id')
                ->constrained('wa_uploads')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('sender');
            $table->longText('message');
            $table->dateTime('wa_datetime');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('wa_messages');
    }
};
