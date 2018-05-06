<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'membership_id', 'meeting_id',
        'amount', 'date', 'payment_receiver_id',
        'creator_id',
    ];
}
