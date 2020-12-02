<?php

namespace Tests\Feature\Auth\Passwords;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ConfirmTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/must-be-confirmed', function () {
            return 'You must be confirmed to see this page.';
        })->middleware(['web', 'password.confirm']);
    }

    /** @test */
    public function a_user_must_confirm_their_password_before_visiting_a_protected_page()
    {
        $user = User::factory()->create();
        $this->be($user);

        $this->get('/must-be-confirmed')
            ->assertRedirect(route('password.confirm'));

        $this->followingRedirects()
            ->get('/must-be-confirmed');
    }
}
