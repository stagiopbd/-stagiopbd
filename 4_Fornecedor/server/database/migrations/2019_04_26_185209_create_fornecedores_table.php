<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('sup_id')->nullable(false);
            $table->string('sup_fantasy_name', 100)->nullable(false);
            $table->dateTime('sup_open_date')->nullable();
            $table->integer('sup_spt_id')->unsigned()->nullable(false);
            $table->timestamp('sup_created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
            $table->timestamp('sup_updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable(false);
            $table->timestamp('sup_deleted_at')->nullable();
            $table->integer('sup_psn_id')->unsigned()->nullable(false);
            $table->foreign('sup_spt_id')->references('spt_id')->on('supplier_type')->onDelete('RESTRICT')->onUpdate('RESTRICT');
            $table->foreign('sup_psn_id')->references('psn_id')->on('person');
//            $table->softDeletes();
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier');
    }
}