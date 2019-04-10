<?php

namespace App\Http\Controllers;

use App\TipoFornecedor;
use App\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
		$fornecedores = Fornecedor::whereNull('deleted_at')->get();
		$total = Fornecedor::whereNull('deleted_at')->get()->count();
        //$fornecedores = Fornecedor::all();
        //$total = Fornecedor::all()->count();
        return view('list-fornecedores', compact('fornecedores', 'total'));
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$tiposdefornecedor = TipoFornecedor::all();
        return view('include-fornecedor', compact('tiposdefornecedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store(Request $request)
    {
		/* Remove a máscara e converte o CNPJ para apenas números */
		$cpnj_num = preg_replace("/[^0-9]/", "", $request->cnpj );
		$request->merge([
			'cnpj' => $cpnj_num,
		]);
		
		$validator = Validator::make($request->all(), [
           'cnpj' => 'required|string|digits:14|unique:fornecedores,cnpj',
           'razao_social' => 'required|string|max:191',
		   'data_abertura' => 'required',	
           'tipofornecedores_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
		
        $fornec = new Fornecedor;
        $fornec->razao_social = $request->razao_social;
        $fornec->data_abertura = $request->data_abertura;
        $fornec->cnpj = $request->cnpj;
        $fornec->tipofornecedores_id = $request->tipofornecedores_id;
        $fornec->save();
        return redirect()->route('fornec.index')->with('message', 'Fornecedor cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
	
	/**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Fornecedor  $fornecedor
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $fornec = Fornecedor::findOrFail($id);
	   $tiposdefornecedor = TipoFornecedor::all();
       return view('alter-fornecedor', compact('fornec','tiposdefornecedor'));
   }
   
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		
		/* Remove a máscara e converte o CNPJ para apenas números */
		$cpnj_num = preg_replace("/[^0-9]/", "", $request->cnpj );
		$request->merge([
			'cnpj' => $cpnj_num,
		]);
		
		$validator = Validator::make($request->all(), [
           'cnpj' => 'required|string|digits:14|unique:fornecedores,cnpj',
           'razao_social' => 'required|string|max:191',
		   'data_abertura' => 'required',	
           'tipofornecedores_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
		
		
        $fornec = Fornecedor::findOrFail($id);
        $fornec->razao_social = $request->razao_social;
        $fornec->data_abertura = $request->data_abertura;
        $fornec->cnpj = $request->cnpj;
        $fornec->tipofornecedores_id = $request->tipofornecedores_id;
        $fornec->save();
        return redirect()->route('fornec.index')->with('message', 'Fornecedor alterado com sucesso!');
    }
	
	 /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fornec = Fornecedor::findOrFail($id);
        $fornec->deleted_at = now();
		$fornec->save();
        return redirect()->route('fornec.index')->with('message', 'Fornecedor deletado com sucesso!');
    }
}