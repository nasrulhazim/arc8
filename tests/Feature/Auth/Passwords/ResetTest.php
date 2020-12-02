<?php

namespace Tests\Feature\Auth\Passwords;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ResetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_view_password_reset_page()
    {
        $user = User::factory()->create();

        $token = Str::random(16);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        $this->get(route('password.reset', [
            'email' => $user->email,
            'token' => $token,
        ]))->assertSuccessful();
    }
}
