<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_type', function (Blueprint $table) {
            $table->increments('spt_id')->nullable(false);
            $table->string('spt_name', 128)->unique()->nullable(false);
            $table->timestamp('spt_created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
            $table->timestamp('spt_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_type');
    }
}