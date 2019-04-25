<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;

    // os campos permitidos de serem preenchidos quando criado um novo registro
    protected $fillable = ['spl_social_name', 'spl_open_date', 'spl_cnpj', 'tsp_id'];

    // relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    protected $table = "spl_suppliers";

    /**
     * Renomeando para exibir padrao trigrama timestamp
 	 */
    const CREATED_AT = 'spl_created_at';
    const UPDATED_AT = 'spl_updated_at';
    const DELETED_AT = 'spl_deleted_at';

 	// relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    public function tipofornecedor()
    {
        return $this->hasOne(TipoFornecedor::class, 'spl_id', 'tsp_id');
    }
    
}
