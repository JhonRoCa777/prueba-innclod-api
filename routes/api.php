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

/*---------------- CLIENTS ----------------*/
Route::prefix('clients')
->controller(ClientController::class)
->group(function () {

    Route::post('/', 'getByDocument');
    Route::post('/', 'create');

    Route::prefix('/{client_id}')
    ->group(function () {

        Route::put('/', 'update');
        Route::delete('/', 'products');
        Route::delete('/', 'orders');
    });
});
