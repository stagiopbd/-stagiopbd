<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFornecedor extends Model
{

/**
     * Renomeando para exibir padrao trigrama timestamp
 		*/
    const CREATED_AT = 'tsp_created_at';
    const UPDATED_AT = 'tsp_updated_at';

    protected $table = "tsp_suppliertypes";
}
