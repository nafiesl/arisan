<?php

use App\Meeting;
use App\Payment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'membership_id'       => 1,
        'meeting_id'          => function () {
            return factory(Meeting::class)->create()->id;
        },
        'amount'              => 999,
        'date'                => today(),
        'payment_receiver_id' => function () {
            return factory(User::class)->create()->id;
        },
        'creator_id'          => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
