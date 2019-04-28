<?php

namespace App\Http\Controllers;

use App\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $medicamentos = Medicamento::paginate(15);
        $total = Medicamento::all()->count();
        return view('list-medicamentos', compact('medicamentos','total'));
    }
}
