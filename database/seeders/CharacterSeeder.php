<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('characters')->insert([

            [
                'character_name' => 'きいち',
                'hp' => 900,
                'attack' => 120,
                'defense' => 90,
                'speed' => 130,
                'intelligence' => 40,
            ],

            [
                'character_name' => 'まさと',
                'hp' => 1300,
                'attack' => 160,
                'defense' => 110,
                'speed' => 70,
                'intelligence' => 30,
            ],

            [
                'character_name' => 'いもと',
                'hp' => 600,
                'attack' => 80,
                'defense' => 60,
                'speed' => 160,
                'intelligence' => 100,
            ],

        ]);
    }
}