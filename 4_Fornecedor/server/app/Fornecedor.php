<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;

    // Renomeando para exibir padrao trigrama timestamp
	const CREATED_AT = 'sup_created_at';
	const UPDATED_AT = 'sup_updated_at'; 
    const DELETED_AT = 'sup_deleted_at';
    protected $primaryKey = 'sup_id';

    // os campos permitidos de serem preenchidos quando criado um novo registro
    protected $fillable = ['sup_fantasy_name','sup_open_date','sup_spt_id','sup_deleted_at','sup_psn_id'];
    protected $guarded = ['sup_id', 'sup_created_at', 'sup_updated_at'];
    // relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    protected $table = "supplier";

 	// relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    public function tipofornecedor()
    {
        return $this->hasOne('App\TipoFornecedor', 'spt_id', 'sup_spt_id');
    }
}
