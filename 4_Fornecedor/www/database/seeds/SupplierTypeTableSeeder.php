<?php

use Illuminate\Database\Seeder;

class SupplierTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/sql/tipo_fornecedor/tipo_fornecedor.sql');
        DB::statement($sql);
    }
}
