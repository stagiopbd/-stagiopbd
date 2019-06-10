<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequisicaoExame;

class RequisicaoExameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $exames = RequisicaoExame::on('mysql_prod')->paginate(15);
        $total = RequisicaoExame::on('mysql_prod')->count();
        return view('list-requisicoes-exames', compact('exames','total'));
    }

    /**
     * Display search results for the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $search = $request->get('patcpf');
        $exames = RequisicaoExame::on('mysql_prod')->where('exr_pat_cpf', 'like', '%'.$search.'%')->paginate(15);
        $total = RequisicaoExame::on('mysql_prod')->count();
        return view('list-requisicoes-exames', compact('exames','total'));
    }
}
