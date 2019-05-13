<?php

namespace App\Http\Controllers;

use App\GrupoExame;
use App\SubitemExame;
use App\TipoExame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class TipoExameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tipos_de_exame = TipoExame::with(array('tipo_grupo_exame','tipo_exame_subitem'))->paginate(15);
        $total = TipoExame::all()->count();
        return view('list-tipos-exame', compact('tipos_de_exame','total'));
    }

    /**
     * Display search results for the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $search = $request->get('descricao_exame');
        $tipos_de_exame = TipoExame::where('ext_description', 'like', '%'.$search.'%')->with(array('tipo_grupo_exame','tipo_exame_subitem'))->paginate(15)->appends('descricao_exame', request('descricao_exame'));;
        $total = TipoExame::all()->count();
        return view('list-tipos-exame', compact('tipos_de_exame','total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos_de_exame = GrupoExame::all();
        $subitens_de_exame = SubitemExame::all();
        return view('include-tipo-exame', compact('grupos_de_exame','subitens_de_exame'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       //Algumas verificações básicas no server-side
       $validator = Validator::make($request->all(), [
            'codigo_exame' => 'max:15',
            'descricao_exame' => 'max:100',
            'tecnica_exame' => 'max:45',  
            'indicacao_exame' => 'max:45'
        ]);
        
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
        
        $novo_tipo_de_exame = new TipoExame;
        $novo_tipo_de_exame->ext_exg_id = $request->grupo_exame;
        $novo_tipo_de_exame->ext_exs_id = $request->subitem_exame;
        $novo_tipo_de_exame->ext_code = $request->codigo_exame;
        $novo_tipo_de_exame->ext_description = $request->descricao_exame;
        $novo_tipo_de_exame->ext_technical = $request->tecnica_exame;
        $novo_tipo_de_exame->ext_indication = $request->indicacao_exame;
        $novo_tipo_de_exame->ext_details = $request->detalhes_exame;
        $novo_tipo_de_exame->ext_paraminitial = $request->param_inicial_input;
        $novo_tipo_de_exame->ext_paramfinal = $request->param_final_input;
        $novo_tipo_de_exame->save();
        return redirect()->route('tipoexame.index')->with('message', 'Tipo de exame cadastrado com sucesso!');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Fornecedor  $fornecedor
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
       $tipo_de_exame = TipoExame::findOrFail($id);
       $grupos_de_exame = GrupoExame::all();
       $subitens_de_exame = SubitemExame::all();
       return view('alter-tipo-exame', compact('tipo_de_exame','grupos_de_exame','subitens_de_exame'));
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
        
       //Algumas verificações básicas no server-side
       $validator = Validator::make($request->all(), [
            'codigo_exame' => 'max:15',
            'descricao_exame' => 'max:100',
            'tecnica_exame' => 'max:45',  
            'indicacao_exame' => 'max:45'
        ]);
        
        if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        $tipo_de_exame_alterar = TipoExame::findOrFail($id);
        $tipo_de_exame_alterar->ext_exg_id = $request->grupo_exame;
        $tipo_de_exame_alterar->ext_exs_id = $request->subitem_exame;
        $tipo_de_exame_alterar->ext_code = $request->codigo_exame;
        $tipo_de_exame_alterar->ext_description = $request->descricao_exame;
        $tipo_de_exame_alterar->ext_technical = $request->tecnica_exame;
        $tipo_de_exame_alterar->ext_indication = $request->indicacao_exame;
        $tipo_de_exame_alterar->ext_details = $request->detalhes_exame;
        $tipo_de_exame_alterar->ext_paraminitial = $request->param_inicial_input;
        $tipo_de_exame_alterar->ext_paramfinal = $request->param_final_input;
        $tipo_de_exame_alterar->save();
        return redirect()->route('tipoexame.index')->with('message', 'Tipo de exame alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fornecedor  $fornecedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo_de_exame_excluir = TipoExame::findOrFail($id);
        $tipo_de_exame_excluir->delete();
        return redirect()->route('tipoexame.index')->with('message', 'Tipo de exame deletado com sucesso!');
    }

}
