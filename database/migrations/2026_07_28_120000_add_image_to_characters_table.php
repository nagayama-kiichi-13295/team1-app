<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {

            // 画像のファイル名のみを保存する
            // 例: 'kiichi.png'
            // 実ファイルは public/images/characters/ に置く
            $table->string('image', 100)
                ->nullable()
                ->after('character_name');
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {

            $table->dropColumn('image');
        });
    }
};
