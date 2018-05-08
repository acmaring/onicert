<?php

use Faker\Generator as Faker;

$factory->define(App\Competencia::class, function (Faker $faker) {
    return [
        'com_id' => $faker->userName,
        'com_name' => $faker->word,
        'com_cant' => $faker->numberBetween($min=1, $max=30),
        'com_esq_id' => 'jimmy52'
        #'com_esq_id' => 'daphney.schmidt'
    ];
});
