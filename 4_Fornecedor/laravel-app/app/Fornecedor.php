<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{

	const CREATED_AT = 'sup_created_at';
	const UPDATED_AT = 'sup_updated_at'; 
    protected $primaryKey = 'sup_id';

    protected $fillable = ['sup_fantasy_name','sup_open_date','sup_spt_id','sup_deleted_at','sup_psn_id'];
    protected $guarded = ['sup_id', 'sup_created_at', 'sup_updated_at'];
    protected $table = 'supplier';

    // relaciona o campo "tipofornecedor_id" com a entidade TipoFornecedor
    //public function tipofornecedor()
    //{
    //    return $this->hasOne(TipoFornecedor::class, 'id', 'tipofornecedores_id');
    //}
}
