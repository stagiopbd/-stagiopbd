<?php

namespace App\Http\Controllers;

use App\TipoFornecedor;
use App\Fornecedor;
use App\Pessoa;
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
        $fornecedores = Fornecedor::whereNull('sup_deleted_at')->with(array('tipo_fornecedor'))->paginate(15);
        $total = Fornecedor::whereNull('sup_deleted_at')->get()->count();
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
            'cnpj' => 'required|string|digits:14|unique:person,psn_cnpjcpf',
            'razao_social' => 'required|string|max:100',
            'data_abertura' => 'required',	
            'tipo_fornecedores_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
		
        $person = new Pessoa;
        $person->psn_name = $request->razao_social;
        $person->psn_cnpjcpf = $request->cnpj;
        $person->save();

        $person_fornec = Pessoa::where('psn_cnpjcpf',$request->cnpj)->get()->first();

        $fornecedor = new Fornecedor;
        $fornecedor->sup_fantasy_name = $request->razao_social;
        $fornecedor->sup_open_date = $request->data_abertura;
        $fornecedor->sup_spt_id = $request->tipo_fornecedores_id;
        $fornecedor->sup_psn_id = $person_fornec->psn_id;
        $fornecedor->save();
        return redirect()->route('fornecedor.index')->with('message', 'Fornecedor cadastrado com sucesso!');
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
       $fornecedor = Fornecedor::findOrFail($id);
       $person = Pessoa::findOrFail($fornecedor->sup_psn_id);
	   $tiposdefornecedor = TipoFornecedor::all();
       return view('alter-fornecedor', compact('fornecedor','tiposdefornecedor','person'));
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
            'cnpj' => 'required|string|digits:14|unique:person,psn_cnpjcpf',
            'razao_social' => 'required|string|max:100',
            'data_abertura' => 'required',  
            'tipo_fornecedores_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        $fornecedor = Fornecedor::findOrFail($id);
        $person = Pessoa::findOrFail($fornecedor->sup_psn_id);

        $person->psn_name = $request->razao_social;
        $person->psn_cnpjcpf = $request->cnpj;
        $person->save();

        $person_fornec = Pessoa::where('psn_cnpjcpf',$request->cnpj)->get()->first();

        $fornecedor->sup_fantasy_name = $request->razao_social;
        $fornecedor->sup_open_date = $request->data_abertura;
        $fornecedor->sup_spt_id = $request->tipo_fornecedores_id;
        $fornecedor->sup_psn_id = $person_fornec->psn_id;
        $fornecedor->save();
        return redirect()->route('fornecedor.index')->with('message', 'Fornecedor alterado com sucesso!');
    }
	
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->sup_deleted_at = now();
        $fornecedor->save();
        return redirect()->route('fornecedor.index')->with('message', 'Fornecedor deletado com sucesso!');
    }
}
