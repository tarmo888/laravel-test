<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
	function database() {
		$query = DB::table('transactions');

		return $query->get()->toArray();
	}

	function csv() {
		$csv = array_map('str_getcsv', file(base_path('database/transactions.csv')));
		$keys = array_shift($csv);
		$data = [];
		foreach ($csv as $i => $row) {
			$data[$i] = array_combine($keys, $row);
			# convert id and user_id column to integers to match database schema
			foreach ($data[$i] as $key => $value) {
				$data[$i][$key] = $key === 'id' || $key === 'user_id' ? intval($value) : $value;
			}
		}

		return $data;
	}

	function combined() {
		return array_merge($this->database(), $this->csv());
	}
}
