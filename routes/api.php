<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->json(['message' => 'Hola Mundo']);
});

/*---------------- CLIENTS ----------------*/
Route::prefix('clients')
->controller(ClientController::class)
->group(function () {

    Route::post('/', 'create');

    Route::get('/{client_document}', 'getByDocument');

    Route::prefix('/{client_id}')
    ->group(function () {

        Route::put('/', 'update');
        Route::get('/products', 'getProducts');
        Route::get('/orders', 'getOrders');

    });
});
