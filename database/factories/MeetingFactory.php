<?php

use App\Group;
use App\Meeting;
use App\User;
use Faker\Generator as Faker;

$factory->define(Meeting::class, function (Faker $faker) {
    return [
        'group_id'   => function () {
            return factory(Group::class)->create()->id;
        },
        'number'     => 1,
        'date'       => today(),
        'place'      => 'Inter Cafe',
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
