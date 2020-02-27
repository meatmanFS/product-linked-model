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

Route::name('api.')->group( function() {
    Route::name('attributes.')->prefix('attributes')->group( function() {
        Route::get('/', 'AttributeController@get')->name('get');
        Route::post('/store', 'AttributeController@store')->name('store');
        Route::delete('/', 'AttributeController@destroy')->name('destroy');
    });
    Route::name('productTypes.')->prefix('productTypes')->group( function() {
        Route::get('/', 'ProductTypeController@get')->name('get');
    });
    Route::name('products.')->prefix('products')->group( function() {
        Route::get('/getType/{product}', 'ProductController@getType')->name('getType');
        Route::get('/getAttributes/{product}', 'ProductController@getAttributes')->name('getAttributes');
        Route::post('/updateAttributes/{product}', 'ProductController@updateAttributes')->name('updateAttributes');
        Route::post('/search', 'ProductController@searchProducts')->name('searchProducts');
        Route::post('/setType', 'ProductController@setType')->name('setType');
    });
});