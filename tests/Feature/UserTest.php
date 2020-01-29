<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
	public function testBasicTest()
	{
		$this->get('/')->assertStatus(200)->assertViewHas('countries');
	}

	public function testGetAustrianUsers()
	{
		$this->json('GET','/api/user/search/at')
			->assertStatus(200)
			->assertJsonFragment([
				'citizenship_country_id' => 1,
			]);
	}

	public function testSaveDetails()
	{
		$this->json('GET', '/api/user/6')
			->assertStatus(200)
			->assertJson([
				'first_name' => 'Max',
				'last_name' => 'Mustermann',
			]);

		$this->json('PUT', '/api/user/6', ['first_name' => 'FIRSTNAME', 'last_name' => 'LASTNAME'])
			->assertStatus(201);

		$this->json('GET', '/api/user/6')
			->assertStatus(200)
			->assertJson([
				'first_name' => 'FIRSTNAME',
				'last_name' => 'LASTNAME',
			]);
	}

	public function testProfileDelete() {
		# deleting user without details should fail
		$this->json('DELETE', '/api/user/1')
			->assertStatus(409);

		# first try should be success
		$this->json('DELETE', '/api/user/2')
			->assertStatus(201);

		# second try should fail
		$this->json('DELETE', '/api/user/2')
			->assertStatus(409);
	}
}
