<?php

use Illuminate\Database\Seeder;

class TipoFornecedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            'Outros',
            'Serviços',
            'Zeladoria e Limpeza',
            'Insumos',
            'Equipamentos',
            'Manutenção',
            'Segurança',
        ];

        foreach ($tipos as $tipo) {
            App\TipoFornecedor::create([
                'tfo_nome' => $tipo
            ]);
        }
    }
}
