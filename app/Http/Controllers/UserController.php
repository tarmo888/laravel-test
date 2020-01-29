<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends BaseController
{
	function search(string $country = null) {
		$query = DB::table('users')->select('user_details.*')
			->join('user_details', 'users.id', '=', 'user_details.user_id')
			->join('countries', 'user_details.citizenship_country_id', '=', 'countries.id')
			->where('active', 1);

		if ($country) {
			$query->where(function ($query) use ($country) {
				$query->where('countries.iso2', strtoupper($country))
					->orWhere('countries.iso3', strtoupper($country));
			});
		}

		return $query->get()->toArray();
	}

	function getDetails(int $user_id) {
		$query = DB::table('users')->select('user_details.*')
			->join('user_details', 'users.id', '=', 'user_details.user_id')
			->where('users.id', $user_id)
			->where('active', 1);

		return (array)$query->first();
	}

	function saveDetails(Request $request, int $user_id) {
		$user_details = $request->only(['citizenship_country_id', 'first_name', 'last_name', 'phone_number']);

		$query = DB::table('user_details')
			->where('user_id', $user_id)
			->update($user_details);

		return response()->json((bool)$query, $query ? 201 : 409);
	}

	function delete(int $user_id) {
		$query = DB::table('users')
			->leftJoin('user_details', 'users.id', '=', 'user_details.user_id')
			->where('users.id', $user_id)
			->whereNull('user_details.id')->delete();

		return response()->json((bool)$query, $query ? 201 : 409);
	}
}
