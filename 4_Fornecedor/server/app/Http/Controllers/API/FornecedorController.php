<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Fornecedor;
use App\Http\Resources\Fornecedor as FornecedorResource;
use App\Http\Resources\FornecedorCollection;
use Illuminate\Http\Response;
use \Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new FornecedorCollection(Fornecedor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'razao_social'  => 'required',
            'data_abertura' => 'required|date',
            'cnpj'          => 'required|unique:fornecedores|digits:14',
            'tipo'          => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->messages(), Response::HTTP_BAD_REQUEST);
        }
        
        $fornecedor = new Fornecedor([
            'razao_social'        => $request->razao_social,
            'data_abertura'       => $request->data_abertura,
            'cnpj'                => $request->cnpj,
            'tipofornecedores_id' => $request->tipo,
        ]);
        $fornecedor->save();

        return $this->show($fornecedor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function show(Fornecedor $fornecedor)
    {
        return new FornecedorResource($fornecedor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $fornecedor->update([
            'razao_social'        => $request->razao_social,
            'data_abertura'       => $request->data_abertura,
            'cnpj'                => $request->cnpj,
            'tipofornecedores_id' => $request->tipo,
        ]);
        $fornecedor->save();

        return $this->show($fornecedor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();
        return response()->json($fornecedor, Response::HTTP_OK);
    }
}
