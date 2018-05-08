<?php

use Faker\Generator as Faker;

$factory->define(App\Respuesta::class, function (Faker $faker) {
    
	return [
	    'res_content' => $faker->word,
	    'res_correct' => 1,
	    'res_pre_id' => 3
	];
});
