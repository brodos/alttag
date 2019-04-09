<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function it_belongs_to_an_owner ()
	{
		$site = factory('App\Site')->create();

		$this->assertInstanceOf(User::class, $site->owner);
	}
}
