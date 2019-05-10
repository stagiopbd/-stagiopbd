<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $fillable = ['med_active_principle', 'med_code_ggrem', 'med_register', 'med_ean1', 'med_ean2', 'med_ean3', 'med_product_description', 'med_presentation', 'med_hospital_restrictions', 'med_cap', 'med_confaz87', 'med_marketing_year', 'med_sup_id', 'med_thc_id', 'med_pdt_id', 'med_stp_id'];
    protected $guarded = ['med_id'];
    protected $table = 'medicine';

    public function fornecedor()
	{
   		return $this->hasOne('App\Fornecedor', 'sup_id', 'med_sup_id');
	}

	public function classe_terapeutica()
	{
   		return $this->hasOne('App\ClasseTerapeutica', 'thc_id', 'med_thc_id');
	}

	public function tipo_produto()
	{
   		return $this->hasOne('App\TipoProduto', 'pdt_id', 'med_pdt_id');
	}

	public function tarja()
	{
   		return $this->hasOne('App\Tarja', 'stp_id', 'med_stp_id');
	}
}
