<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateInvoicesTest extends TestCase
{
	function an_authenticated_user_can_create_invoices()
	{
		// Given we have a signed in user
		$this->actingAs(factory('App\User')->create());
	}
}
