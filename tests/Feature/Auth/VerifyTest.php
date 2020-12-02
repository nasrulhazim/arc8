<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class VerifyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_verification_page()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Auth::login($user);

        $this->get(route('verification.notice'))
            ->assertSuccessful();
    }

    /** @test */
    public function can_verify()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Auth::login($user);

        $url = URL::temporarySignedRoute('verification.verify', Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)), [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);

        $this->get($url)
            ->assertRedirect(route('dashboard'));

        $this->assertTrue($user->hasVerifiedEmail());
    }
}
