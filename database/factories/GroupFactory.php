<?php

use App\Group;
use App\User;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name'           => $faker->words(2, true),
        'capacity'       => 20,
        'currency'       => 'IDR',
        'payment_amount' => 50000,
        'description'    => $faker->sentence,
        'creator_id'     => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
