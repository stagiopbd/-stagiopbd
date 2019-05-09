<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    protected $fillable = ['pdt_description'];
    protected $guarded = ['pdt_id'];
    protected $table = 'product_type';
}
