<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedoresTable extends Migration
{
    /**
     * Tabela "fornecedores" que armazena os dados do fornecedor cadastrado.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('for_fornecedores', function (Blueprint $table) {
            $table->increments('for_id');
            $table->string('for_razao_social');
            $table->dateTime('for_data_abertura');
            $table->string('for_cnpj', 14)->unique();
            $table->integer('tfo_id')->unsigned();
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
        Schema::dropIfExists('for_fornecedores');
    }
}
