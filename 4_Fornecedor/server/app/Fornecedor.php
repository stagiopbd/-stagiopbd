<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = "fornecedores";

    // relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    public function tipofornecedor()
    {
        return $this->hasOne(TipoFornecedor::class, 'id', 'tipofornecedores_id');
    }
}
