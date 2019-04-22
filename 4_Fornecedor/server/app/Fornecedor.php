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
    protected $table = "for_fornecedores";

    /**
     * Renomeando para exibir padrao trigrama timestamp
 	 */
    const CREATED_AT = 'for_created_at';
    const UPDATED_AT = 'for_updated_at';
    const DELETED_AT = 'for_deleted_at';

 	// relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    public function tipofornecedor()
    {
        return $this->hasOne(TipoFornecedor::class, 'for_id', 'tfo_id');
    }
    
}
