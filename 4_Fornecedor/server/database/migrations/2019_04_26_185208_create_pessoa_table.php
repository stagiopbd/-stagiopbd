<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table) {
            $table->increments('psn_id')->nullable(false);
            $table->string('psn_name', 100)->nullable(false);
            $table->char('psn_cnpjcpf', 14)->unique()->nullable(false);
            $table->string('psn_address', 50)->nullable();
            $table->integer('psn_number')->nullable();
            $table->string('psn_complement', 15)->nullable();
            $table->string('psn_neighborhood', 45)->nullable();
            $table->string('psn_city', 45)->nullable();
            $table->char('psn_estate', 2)->nullable();
            $table->char('psn_zipcode', 8)->nullable();
            $table->string('psn_country', 45)->nullable();
            $table->char('psn_phone_inter_code', 2)->nullable();
            $table->char('psn_phone_area_code', 3)->nullable();
            $table->char('psn_phone_number', 9)->nullable();
            $table->string('psn_email', 60)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person');
    }
}
