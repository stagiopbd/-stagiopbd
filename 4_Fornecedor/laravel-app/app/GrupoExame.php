<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrupoExame extends Model
{
    protected $fillable = ['exg_name'];
    protected $guarded = ['exg_id'];
    protected $table = 'exam_group';
}
