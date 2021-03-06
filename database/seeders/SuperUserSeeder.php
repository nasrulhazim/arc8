<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate([
            'name' => 'Superadmin',
            'email' => 'superadmin@app.com',
        ], [
            'password' => Hash::make('StrongPassword1234^|'),
            'email_verified_at' => now(),
        ]);

        $user->assignRole(['user', 'administrator', 'superadmin']);

        $user->ownedTeams()->save(Team::forceCreate([
            'uuid' => uuid(),
            'user_id' => $user->id,
            'name' => config('app.name'),
            'personal_team' => true,
        ]));

        event(new Registered($user));
    }
}
