<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarja extends Model
{
    protected $fillable = ['stp_description'];
    protected $guarded = ['stp_id'];
    protected $table = 'stripe';
}
