<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoFornecedoresTable extends Migration
{
    /**
     * Tabela "tipofornecedores" que armazena o segmento na qual determinado
     * fornecedor atua. Tabela de referência, para otimizar o uso do espaço.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipofornecedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->unique();
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
        Schema::dropIfExists('tipofornecedores');
    }
}
