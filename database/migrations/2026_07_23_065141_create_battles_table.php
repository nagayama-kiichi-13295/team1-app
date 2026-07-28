<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_id')
                ->constrained('rooms');

            $table->integer('player1_hp')->default(100);
            $table->integer('player2_hp')->default(100);

            $table->integer('turn_player')->default(1);

            $table->foreignId('winner_user_id')
                ->nullable()
                ->constrained('users');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('battles');
    }
};