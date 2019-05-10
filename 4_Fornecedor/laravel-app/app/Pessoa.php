<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
	public $timestamps = false;
	protected $primaryKey = 'per_id';

    protected $fillable = ['per_name', 'per_cnpjcpf', 'per_address', 'per_number', 'per_complement', 'per_neighborhood', 'per_city', 'per_estate', 'per_zipcode', 'per_country', 'per_phone_inter_code', 'per_phone_area_code', 'per_phone_number', 'per_email'];
    protected $guarded = ['per_id'];
    protected $table = 'person';
}
