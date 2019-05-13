<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemExame extends Model
{
    protected $fillable = ['exi_name'];
    protected $guarded = ['exi_id'];
    protected $table = 'exam_item';
}
