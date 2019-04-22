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
        Schema::create('tfo_tipofornecedores', function (Blueprint $table) {
            $table->increments('tfo_id');
            $table->string('tfo_nome')->unique();
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
        Schema::dropIfExists('tfo_tipofornecedores');
    }
}
