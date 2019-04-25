<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoFornecedoresTable extends Migration
{
    /**
     * Tabela "suppliertypes" que armazena o segmento na qual determinado
     * fornecedor atua. Tabela de referência, para otimizar o uso do espaço.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsp_suppliertypes', function (Blueprint $table) {
            $table->increments('tsp_id');
            $table->string('tsp_name')->unique();
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
        Schema::dropIfExists('tsp_suppliertypes');
    }
}
