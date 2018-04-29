<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'group_id', 'number', 'date',
        'place', 'notes', 'creator_id',
    ];
}
