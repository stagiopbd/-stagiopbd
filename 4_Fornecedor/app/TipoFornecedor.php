<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFornecedor extends Model
{
    protected $fillable = ['nome'];
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'tipo_fornecedores';
}
