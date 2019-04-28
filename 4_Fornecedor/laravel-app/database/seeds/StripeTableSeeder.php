<?php

use Illuminate\Database\Seeder;

class StripeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path() . '/seeds/sql/tarja/tarja.sql');
        DB::statement($sql);
    }
}
