<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedoresTable extends Migration
{
    /**
     * Tabela "suppliers" que armazena os dados do fornecedor cadastrado.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spl_suppliers', function (Blueprint $table) {
            $table->increments('spl_id');
            $table->string('spl_social_name');
            $table->dateTime('spl_open_date');
            $table->string('spl_cnpj', 14)->unique();
            $table->integer('tsp_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spl_suppliers');
    }
}
