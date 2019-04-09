<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;

    protected $table = "fornecedores";

    // os campos permitidos de serem preenchidos quando criado um novo registro
    protected $fillable = ['razao_social', 'data_abertura', 'cnpj', 'tipofornecedores_id'];

    // relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    public function tipofornecedor()
    {
        return $this->hasOne(TipoFornecedor::class, 'id', 'tipofornecedores_id');
    }
}
