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
            $table->increments('per_id')->nullable(false);
            $table->string('per_name', 100)->nullable(false);
            $table->char('per_cnpjcpf', 14)->unique()->nullable(false);
            $table->string('per_address', 50)->nullable();
            $table->integer('per_number')->nullable();
            $table->string('per_complement', 15)->nullable();
            $table->string('per_neighborhood', 45)->nullable();
            $table->string('per_city', 45)->nullable();
            $table->char('per_state', 2)->nullable();
            $table->char('per_zipcode', 8)->nullable();
            $table->string('per_country', 45)->nullable();
            $table->char('per_phone_inter_code', 2)->nullable();
            $table->char('per_phone_area_code', 3)->nullable();
            $table->char('per_phone_number', 9)->nullable();
            $table->string('per_email', 60)->nullable();
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
