<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('battles', function (Blueprint $table) {
            $table->integer('player1_mp')
                ->default(30);

            $table->integer('player2_mp')
                ->default(30);

        });
    }

    public function down(): void
    {
        Schema::table('battles', function (Blueprint $table) {

            $table->dropColumn([
                'player1_mp',
                'player2_mp'
            ]);

        });
    }
};