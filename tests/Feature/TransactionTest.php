<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
	public function testDatabase()
	{
		$this->json('GET','/api/transaction/database')
			->assertStatus(200);
	}

	public function testCSV()
	{
		$this->json('GET','/api/transaction/csv')
			->assertStatus(200);
	}

	public function testCombined()
	{
		$this->json('GET','/api/transaction')
			->assertStatus(200);
	}
}
