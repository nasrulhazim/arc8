<?php

namespace Tests\Feature\Auth\Passwords;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_password_request_page()
    {
        $this->get(route('password.request'))
            ->assertSuccessful();
    }
}
