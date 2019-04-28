<?php

use Illuminate\Database\Seeder;

class TherapeuticClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/sql/classe_terapeutica/classe_terapeutica.sql');
        DB::statement($sql);
    }
}
