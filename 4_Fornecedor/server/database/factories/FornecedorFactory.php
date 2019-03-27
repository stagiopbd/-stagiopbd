<?php

use Faker\Generator as Faker;
use App\TipoFornecedor as TipoFornecedor;

$factory->define(App\Fornecedor::class, function (Faker $faker) {
    return [
        'razao_social' => $faker->name,
        'data_abertura' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'cnpj' => $faker->cnpj(false),
        'tipofornecedores_id' => TipoFornecedor::inRandomOrder()->first()->id,
    ];
});
