<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('battles', function (Blueprint $table) {

            $table->integer('player1_attack_buff')
                ->default(0);

            $table->integer('player2_attack_buff')
                ->default(0);

            $table->integer('player1_defense_buff')
                ->default(0);

            $table->integer('player2_defense_buff')
                ->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('battles', function (Blueprint $table) {

            $table->dropColumn([
                'player1_attack_buff',
                'player2_attack_buff',
                'player1_defense_buff',
                'player2_defense_buff'
            ]);

        });
    }
};