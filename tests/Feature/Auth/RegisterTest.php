<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_page_contains_livewire_component()
    {
        $this->get(route('register'))
            ->assertSuccessful();
    }

    /** @test */
    public function is_redirected_if_already_logged_in()
    {
        $user = User::factory()->create();

        $this->be($user);

        $this->get(route('register'))
            ->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function name_is_required()
    {
        $response = $this->post(route('register'), [
            'name' => '',
            'email' => 'lorem@ipsum.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
        ]);
    }

    /** @test */
    public function email_is_required()
    {
        $response = $this->post(route('register'), [
            'name' => 'lorem ipsum',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
        ]);
    }

    /** @test */
    public function email_is_valid_email()
    {
        $response = $this->post(route('register'), [
            'name' => 'lorem ipsum',
            'email' => 'lorem ipsum',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.',
        ]);
    }

    /** @test */
    public function password_is_required()
    {
        $response = $this->post(route('register'), [
            'name' => 'lorem ipsum',
            'email' => 'lorem@ipsum.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.',
        ]);
    }
}
