<?php

use Illuminate\Database\Seeder;

class MedicineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parte1 = file_get_contents(database_path() . '/seeds/sql/medicamentos/medicamentos_parte1.sql');
        DB::unprepared($parte1);

        $parte2 = file_get_contents(database_path() . '/seeds/sql/medicamentos/medicamentos_parte2.sql');
        DB::unprepared($parte2);

        $parte3 = file_get_contents(database_path() . '/seeds/sql/medicamentos/medicamentos_parte3.sql');
        DB::unprepared($parte3);

        $parte4 = file_get_contents(database_path() . '/seeds/sql/medicamentos/medicamentos_parte4.sql');
        DB::unprepared($parte4);

        $parte5 = file_get_contents(database_path() . '/seeds/sql/medicamentos/medicamentos_parte5.sql');
        DB::unprepared($parte5);

        $parte6 = file_get_contents(database_path() . '/seeds/sql/medicamentos/medicamentos_parte6.sql');
        DB::unprepared($parte6);
    }
}
