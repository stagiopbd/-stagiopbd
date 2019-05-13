<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoExame extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'ext_id';

    protected $fillable = ['ext_exg_id', 'ext_exs_id', 'ext_code', 'ext_description', 'ext_technical', 'ext_indication', 'ext_details', 'ext_paraminitial', 'ext_paramfinal'];
    protected $guarded = ['ext_id'];
    protected $table = 'exam_type';

    public function tipo_grupo_exame()
    {
       return $this->hasOne('App\GrupoExame', 'exg_id', 'ext_exg_id');
    }

    public function tipo_exame_subitem()
    {
       return $this->hasOne('App\SubitemExame', 'exs_id', 'ext_exs_id');
    }
}
