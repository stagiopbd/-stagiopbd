<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFornecedor extends Model
{

/**
     * Renomeando para exibir padrao trigrama timestamp
 		*/
    const CREATED_AT = 'tfo_created_at';
    const UPDATED_AT = 'tfo_updated_at';

    protected $table = "tfo_tipofornecedores";
}
