<?php

use Faker\Generator as Faker;
use App\TipoFornecedor as TipoFornecedor;

$factory->define(App\Fornecedor::class, function (Faker $faker) {
    return [
        'for_razao_social' => $faker->name,
        'for_data_abertura' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'for_cnpj' => $faker->cnpj(false),
        'tfo_id' => TipoFornecedor::inRandomOrder()->first()->id,
    ];
});
