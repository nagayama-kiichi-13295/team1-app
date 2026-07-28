<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'host_user_id',
        'guest_user_id',
        'status',
        'host_character_id',
        'guest_character_id',
    ];
}