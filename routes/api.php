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

Route::get('/user/search/{country?}', 'UserController@search');
Route::get('/user/{user_id}', 'UserController@getDetails');
Route::put('/user/{user_id}', 'UserController@saveDetails');
Route::delete('/user/{user_id}', 'UserController@delete');

Route::get('/transaction/database', 'TransactionController@database');
Route::get('/transaction/csv', 'TransactionController@csv');
Route::get('/transaction', 'TransactionController@combined');
