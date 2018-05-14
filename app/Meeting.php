<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'group_id', 'number', 'date',
        'place', 'notes', 'creator_id',
        'winner_id',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function winner()
    {
        return $this->belongsTo(Membership::class)->withDefault(['user' => '-']);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
