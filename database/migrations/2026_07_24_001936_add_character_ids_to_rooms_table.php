<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    

    /**
     * Reverse the migrations.
     */
public function up(): void
{
    Schema::table('rooms', function (Blueprint $table) {

        $table->unsignedBigInteger('host_character_id')
              ->nullable();

        $table->unsignedBigInteger('guest_character_id')
              ->nullable();
    });
}

public function down(): void
{
    Schema::table('rooms', function (Blueprint $table) {

        $table->dropColumn('host_character_id');
        $table->dropColumn('guest_character_id');
    });
}
};
