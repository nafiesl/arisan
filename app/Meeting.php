<?php

namespace App;

use App\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'group_id', 'number', 'date',
        'place', 'notes', 'creator_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
