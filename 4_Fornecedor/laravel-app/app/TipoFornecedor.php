<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFornecedor extends Model
{
    protected $fillable = ['spt_name'];
    protected $guarded = ['spt_id', 'spt_created_at', 'spt_updated_at'];
    protected $table = 'supplier_type';
}
