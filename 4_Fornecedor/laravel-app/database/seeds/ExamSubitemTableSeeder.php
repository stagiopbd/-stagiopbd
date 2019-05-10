<?php

use Illuminate\Database\Seeder;

class ExamSubitemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/sql/subitem_exame/subitem_exame.sql');
        DB::statement($sql);
    }
}
