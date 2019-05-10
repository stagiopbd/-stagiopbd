<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubitemExameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_subitem', function (Blueprint $table) {
            $table->increments('exs_id')->nullable(false);
            $table->string('exs_name', 45)->nullable();
            $table->integer('exs_exi_id')->unsigned()->nullable(false);
            $table->foreign('exs_exi_id')->references('exi_id')->on('exam_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_subitem');
    }
}
