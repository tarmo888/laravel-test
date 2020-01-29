<?php
use Illuminate\Support\Facades\DB;

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
	$countries = DB::table('countries')
		->select('id', 'name')
		->orderBy('name')
		->pluck('name', 'id')
		->toArray();

	return view('welcome', [
		'countries' => $countries
	]);
});
