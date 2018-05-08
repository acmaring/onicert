<?php

use Faker\Generator as Faker;

$factory->define(App\Esquema::class, function (Faker $faker) {
    return [
        'esq_id' => $faker->unique()->userName,
        'esq_name' => $faker->word,
        #'esq_parent' => $faker->numberBetween($min=0, $max=3),
        'esq_parent' => 0,
        'esq_cant' => $faker->numberBetween($min=1, $max=30)
    ];
});
