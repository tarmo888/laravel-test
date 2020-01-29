<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('user:search {country?}', function (string $country = null) {
	$userController = new UserController();
	$headers = ['id', 'user_id', 'citizenship_country_id', 'first_name', 'last_name', 'phone_number'];
	$dataArray = json_decode(json_encode($userController->search($country)), true); // convert to array
	$this->table($headers, $dataArray);
})->describe('Command to search users by country code');

Artisan::command('user:load {user_id}', function (int $user_id) {
	$userController = new UserController();
	$headers = ['key', 'value'];
	$dataArray = $userController->getDetails($user_id);
	if ($dataArray) {
		// create table format
		$dataArray = array_map(function($key, $value) {
			return ['key' => $key, 'value' => $value];
		}, array_keys($dataArray), $dataArray);
		$this->table($headers, $dataArray);
	}
	else {
		$this->error('Not found');
	}
})->describe('Command to get user by id');

Artisan::command('user:save {user_id} {citizenship_country_id?} {first_name?} {last_name?} {phone_number?}', function (int $user_id, int $citizenship_country_id = null, string $first_name = null, string $last_name = null, string $phone_number = null) {
	$data = compact('citizenship_country_id', 'first_name', 'last_name', 'phone_number'); // create array with keys
	$data = array_filter($data, 'strlen'); // remove empty values

	if (!$data) {
		$this->error('No data to save');
	}
	else {
		$query = DB::table('user_details')
			->where('user_id', $user_id)
			->update($data);

		if ($query) {
			$this->info('OK');
		}
		else {
			$this->error('Error');
		}
	}
})->describe('Command to save user details');

Artisan::command('user:delete {user_id}', function (int $user_id) {
	$query = DB::table('users')
		->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
		->where('users.id', $user_id)
		->whereNull('user_details.id')->delete();

	if ($query) {
		$this->info('OK');
	}
	else {
		$this->error('Error');
	}
})->describe('Command to delete user by id');


Artisan::command('transaction:get {method?}', function (string $method = 'combined') {
	$transactionController = new TransactionController();
	$headers = ['id', 'code', 'amount', 'user_id', 'created_at', 'updated_at'];
	$data = [];
	switch ($method) {
	case 'database':
		$data = $transactionController->database();
		break;
	case 'csv':
		$data = $transactionController->csv();
		break;
	case 'combined':
	default:
		$data = $transactionController->combined();
		break;
	}
	$dataArray = json_decode(json_encode($data), true); // convert to array
	$this->table($headers, $dataArray);
})->describe('Command to get transactions from database, csv or combined (default)');