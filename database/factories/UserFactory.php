<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'firstname' => $faker->firstName,
        'adresse' => $faker->streetAddress,
        'city' => $faker->city,
        'postal_code' => $faker->postcode,
        'email_verified_at' => now(),
        'password' => '$2y$10$NhWYjzwvQZh369L4pdj5n.L6KDnDOek0RhcrQRwGu3dTG0WzOSoHC', // secret
        'remember_token' => str_random(10),
    ];
});



