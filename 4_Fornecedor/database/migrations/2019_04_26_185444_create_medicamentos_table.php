<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine', function (Blueprint $table) {
            $table->increments('med_id')->nullable(false);
            $table->mediumText('med_active_principle')->nullable();
            $table->char('med_code_ggrem', 15)->nullable();
            $table->char('med_register', 13)->nullable();
            $table->char('med_ean1', 14)->nullable();
            $table->char('med_ean2', 14)->nullable();
            $table->char('med_ean3', 14)->nullable();
            $table->string('med_product_description', 120)->nullable();
            $table->string('med_presentation', 200)->nullable();
            $table->tinyInteger('med_hospital_restrictions')->nullable();
            $table->tinyInteger('med_cap')->nullable();
            $table->tinyInteger('med_confaz87')->nullable();
            $table->integer('med_marketing_year')->nullable();
            $table->integer('med_sup_id')->unsigned()->nullable(false);
            $table->integer('med_thc_id')->unsigned()->nullable(false);
            $table->integer('med_pdt_id')->unsigned()->nullable(false);
            $table->integer('med_stp_id')->unsigned()->nullable(false);
            $table->foreign('med_sup_id')->references('sup_id')->on('supplier');
            $table->foreign('med_thc_id')->references('thc_id')->on('therapeutic_class');
            $table->foreign('med_pdt_id')->references('pdt_id')->on('product_type');
            $table->foreign('med_stp_id')->references('stp_id')->on('stripe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine');
    }
}
