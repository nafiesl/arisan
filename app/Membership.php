<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'group_members';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
