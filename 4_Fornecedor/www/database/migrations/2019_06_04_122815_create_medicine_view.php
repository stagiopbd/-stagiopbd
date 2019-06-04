<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicineView extends Migration
{
    public function up()
    {
        DB::statement("CREATE VIEW v_medicines AS
                      SELECT * FROM medicine ORDER BY med_id");
    }

    public function down()
    {
        DB::statement("DROP VIEW v_medicines");
    }
}
