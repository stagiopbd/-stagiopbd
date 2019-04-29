<?php

namespace App\Http\Controllers;

use App\Fornecedor;
use App\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if($request->has('tarja')){
            $medicamentos = Medicamento::where('med_stp_id', request('tarja'))->with(array('fornecedor','classe_terapeutica','tipo_produto','tarja'))->paginate(15)->appends('tarja', request('tarja'));
        }
        else{
            $medicamentos = Medicamento::with(array('fornecedor','classe_terapeutica','tipo_produto','tarja'))->paginate(15);
        }
        $total = Medicamento::all()->count();
        return view('list-medicamentos', compact('medicamentos','total'));
    }

    /**
     * Display search results for the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $search = $request->get('descricao');
        $medicamentos = Medicamento::where('med_product_description', 'like', '%'.$search.'%')->with(array('fornecedor','classe_terapeutica','tipo_produto','tarja'))->paginate(15)->appends('descricao', request('descricao'));;
        $total = Medicamento::all()->count();
        return view('list-medicamentos', compact('medicamentos','total'));
    }
}
