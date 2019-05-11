<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoExameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_type', function (Blueprint $table) {
            $table->increments('ext_id')->nullable(false);
            $table->integer('ext_exg_id')->unsigned()->nullable(false);
            $table->integer('ext_exs_id')->unsigned()->nullable(false);
            $table->char('ext_code', 15)->nullable();
            $table->string('ext_description', 100)->nullable();
            $table->string('ext_technical', 45)->nullable();
            $table->string('ext_indication', 45)->nullable();
            $table->text('ext_details')->nullable();
            $table->float('ext_paraminitial')->nullable();
            $table->float('ext_paramfinal')->nullable();
            $table->foreign('ext_exg_id')->references('exg_id')->on('exam_group');
            $table->foreign('ext_exs_id')->references('exs_id')->on('exam_subitem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_type');
    }
}
