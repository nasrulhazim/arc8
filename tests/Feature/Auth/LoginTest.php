<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_login_page()
    {
        $this->get(route('login'))
            ->assertSuccessful();
    }

    /** @test */
    public function is_redirected_if_already_logged_in()
    {
        $user = User::factory()->create();

        $this->be($user);

        $this->get(route('login'))
            ->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function a_user_can_login()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function is_redirected_to_the_home_page_after_login()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function email_is_required()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->post(route('login'), [
            'email' => null,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function email_must_be_valid_email()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->post(route('login'), [
            'email' => 'invalid-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function password_is_required()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => null,
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function bad_login_attempt()
    {
        $response = $this->post(route('login'), [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password', 'email']);
    }
}
