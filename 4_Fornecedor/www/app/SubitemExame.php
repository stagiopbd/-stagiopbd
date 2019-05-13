<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubitemExame extends Model
{
    protected $fillable = ['exs_name','exs_exi_id'];
    protected $guarded = ['exs_id'];
    protected $table = 'exam_subitem';
}
