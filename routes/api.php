<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
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

    Route::post('/', 'create')->name('clients.create');

    Route::get('/{client_document}', 'getByDocument')->name('clients.getByDocument');

    Route::prefix('/{client_id}')
    ->group(function () {

        Route::put('/', 'update')->name('clients.update');
        Route::get('/products', 'getProducts')->name('clients.getProducts');
        Route::get('/orders', 'getOrders')->name('clients.getOrders');

    });
});

/*---------------- ORDERS ----------------*/
Route::prefix('orders')
->controller(OrderController::class)
->group(function () {

    Route::post('/', 'create')->name('orders.create');

});
