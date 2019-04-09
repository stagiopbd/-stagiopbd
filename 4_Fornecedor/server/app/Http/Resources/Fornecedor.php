<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Fornecedor extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'razao_social' => $this->razao_social,
            'data_abertura' => $this->data_abertura,
            'cnpj' => $this->cnpj,
            'tipo' => $this->tipofornecedor->nome,
        ];
    }
}
