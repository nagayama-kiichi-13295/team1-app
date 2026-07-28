<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'skill_name',
        'power',
        'mp_cost',
    ];
}
