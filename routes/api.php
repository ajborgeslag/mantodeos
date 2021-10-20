<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\CategoriaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => []], function() {
    //Categoria
    Route::get('/categoria/list','CategoriaController@index');
    Route::get('/categoria/popular','CategoriaController@popular');
    //producto
    Route::post('/producto/search','ProductoController@search');
    Route::post('/producto/search-cat','ProductoController@searchCategoria');
    Route::get('/producto/popular','ProductoController@popular');
    Route::get('/producto/{id}','ProductoController@show');
    Route::post('/producto/listByIds','ProductoController@listByIds');

    //ShoppingCart
    Route::get('cart/list', 'CartController@cartList');
    Route::post('cart/add', 'CartController@addToCart');
    Route::delete('cart/empty', 'CartController@emptyCart');
    Route::post('cart/update', 'CartController@updateCart');
    Route::delete('cart/remove', 'CartController@removeProduct');

});
