<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('character_name', 50);
            $table->integer('hp')->default(100);
            $table->integer('attack')->default(10);
            $table->integer('defense')->default(5);
            $table->integer('speed')->default(10);
            $table->integer('intelligence')->default(10);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};