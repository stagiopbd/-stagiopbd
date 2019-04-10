<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
	protected $fillable = ['razao_social','data_abertura','cnpj','tipofornecedores_id','deleted_at'];
	protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'fornecedores';

    // relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    public function tipofornecedor()
    {
        return $this->hasOne(TipoFornecedor::class, 'id', 'tipofornecedores_id');
    }
}
