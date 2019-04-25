<?php

use Faker\Generator as Faker;
use App\TipoFornecedor as TipoFornecedor;

$factory->define(App\Fornecedor::class, function (Faker $faker) {
    return [
        'spl_social_name' => $faker->name,
        'spl_open_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'spl_cnpj' => $faker->cnpj(false),
        'tsp_id' => TipoFornecedor::inRandomOrder()->first()->tsp_id,
    ];
});
