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

// List contacts
Route::get('contacts/', 'ContactController@index');
// List single contact
Route::get('contact/{id}', 'ContactController@show');
// create new contact
Route::post('contact/', 'ContactController@store');
// update contact
Route::patch('contact/{id}', 'ContactController@update');
// delete contact
Route::delete('contact/{id}', 'ContactController@destroy');

// register use
Route::post('register', 'Auth\RegisterController@register');
