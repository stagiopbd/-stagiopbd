<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClasseTerapeutica extends Model
{
    protected $fillable = ['thc_description'];
    protected $guarded = ['thc_id'];
    protected $table = 'therapeutic_class';
}
