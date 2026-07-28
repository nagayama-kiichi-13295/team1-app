<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'character_name',
        'image',
        'hp',
        'attack',
        'defense',
        'speed',
        'intelligence',
    ];
}