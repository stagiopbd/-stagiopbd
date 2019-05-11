<?php

use Illuminate\Database\Seeder;

class ExamGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/sql/grupo_exame/grupo_exame.sql');
        DB::statement($sql);
    }
}
