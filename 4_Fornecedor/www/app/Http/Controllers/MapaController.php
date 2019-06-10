<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ahsan\Neo4j\Facade\Cypher;

class MapaController extends Controller
{
    /**
     * Display a map.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pacientes_com_sarampo = Cypher::run("MATCH (p:Patient)-[:HAS_ADDRESS]->(a:Address)-[:HAS_ZIPCODE]->(z:Zipcode) RETURN collect(p.cpf), z.lat, z.long")->getRecords();
        return view('show-mapa', compact('pacientes_com_sarampo'));
    }
}
