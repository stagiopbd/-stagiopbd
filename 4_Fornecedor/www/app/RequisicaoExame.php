<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequisicaoExame extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'exr_id';

    protected $fillable = ['exr_pat_cpf', 'exr_phy_cpf', 'ext_hsp_seq', 'exr_sup_id', 'exr_date_request', 'exr_date_forecast_release', 'exr_date_delivery', 'exr_urgency', 'exr_result'];
    protected $guarded = ['exr_id'];
    protected $table = 'exam_request';
}
