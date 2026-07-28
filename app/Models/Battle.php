<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Battle extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'player1_hp',
        'player2_hp',
        'turn_player',
        'winner_user_id',
        'player1_character_id',
        'player2_character_id',
    ];
}