<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_add_a_site ()
    {
    	// $this->withoutExceptionHandling();

    	$this->get(route('user-sites.create'))
    		->assertStatus(302)
    		->assertRedirect(route('login'));

    	$attributes = factory('App\Site')->raw();

    	$this->post(route('user-sites.store'), $attributes)
    		->assertStatus(302)
    		->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_update_a_site ()
    {
    	$site = factory('App\Site')->create();

    	$this->get(route('user-sites.edit', $site))
    		->assertStatus(302)
    		->assertRedirect(route('login'));

    	$this->patch(route('user-sites.update', $site), ['display_name' => 'example.com'])
    		->assertStatus(302)
    		->assertRedirect(route('login'));
    }

    /** @test */
    public function guest_cannot_delete_a_site ()
    {
    	$site = factory('App\Site')->create();

    	$this->delete(route('user-sites.delete', $site))
    		->assertStatus(302)
    		->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_view_only_his_sites ()
    {
    	$site = factory('App\Site')->create();

    	$this->signIn();

    	$this->get(route('user-sites.show', $site))
    		->assertForbidden();

    	$this->get(route('user-sites.index'))
    		->assertDontSee($site->display_name);
    }

    /** @test */
    public function a_user_can_view_his_sites ()
    {
    	$site = factory('App\Site')->create();

    	$this->signIn($site->owner);

    	$this->get(route('user-sites.index'))
    		->assertOk()
    		->assertSee($site->display_name)
    		->assertSee($site->domain);
    }

    /** @test */
    public function a_user_can_create_a_site ()
    {
    	// $this->withoutExceptionHandling();

    	$user = factory('App\User')->create();

    	$this->signIn($user);

    	$this->get(route('user-sites.create'))
    		->assertStatus(200);

    	$attributes = factory('App\Site')->raw(['user_id' => $user->id]);

		$response = $this->post(route('user-sites.store'), $attributes)
    		->assertStatus(302);

    	// dd($response->headers->get('Location'));

    	$this->get($response->headers->get('Location'))
    		->assertSee($attributes['display_name'])
    		->assertSee($attributes['domain']);
    }

    /** @test */
    public function a_site_needs_an_url ()
    {
    	$user = factory('App\User')->create();
    	$this->signIn($user);

    	$attributes = factory('App\Site')->raw(['url' => '']);

    	$this->post(route('user-sites.store'), $attributes)
    		->assertSessionHasErrors(['url']);
    }
}
