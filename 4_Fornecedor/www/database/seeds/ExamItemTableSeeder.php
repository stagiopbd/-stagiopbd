<?php

use Illuminate\Database\Seeder;

class ExamItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/sql/item_exame/item_exame.sql');
        DB::statement($sql);
    }
}
