<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('mapa','MapaController');
Route::get('exame/search','RequisicaoExameController@search');
Route::resource('exame','RequisicaoExameController');
Route::get('tipoexame/search','TipoExameController@search');
Route::resource('tipoexame','TipoExameController');
Route::get('fornecedor/search','FornecedorController@search');
Route::resource('fornecedor','FornecedorController');
Route::get('medicamento/search','MedicamentoController@search');
Route::resource('medicamento','MedicamentoController');