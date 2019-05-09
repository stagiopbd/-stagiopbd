<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
	public $timestamps = false;
	protected $primaryKey = 'psn_id';

    protected $fillable = ['psn_name', 'psn_cnpjcpf', 'psn_address', 'psn_number', 'psn_complement', 'psn_neighborhood', 'psn_city', 'psn_estate', 'psn_zipcode', 'psn_country', 'psn_phone_inter_code', 'psn_phone_area_code', 'psn_phone_number', 'psn_email'];
    protected $guarded = ['psn_id'];
    protected $table = 'person';
}
