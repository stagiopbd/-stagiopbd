<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// FORNECEDORES ---------------------------------------------------------------

// Route::get('/fornecedor/{fornecedor}', function (Fornecedor $fornecedor) {
//     return new FornecedorResource($fornecedor);
// });

// Route::get('/fornecedores', function () {
//     return new FornecedorCollection(Fornecedor::all());
// });

Route::apiResource('fornecedor', 'API\FornecedorController');