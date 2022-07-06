<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organization;
use App\User;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address
    ];
});
