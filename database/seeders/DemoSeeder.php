n<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTeams();
    }

    private function createTeams()
    {
        $data = json_decode(
            file_get_contents(storage_path('/data/demo/teams.json'))
        );

        foreach ($data as $datum) {
            $user = \App\Models\User::updateOrCreate([
                'email' => $datum->email,
            ], [
                'name' => $datum->name,
                'password' => Hash::make('StrongPassword1234^|'),
                'email_verified_at' => now(),
            ]);

            $user->assignRole(['user']);

            $team = \App\Models\Team::create([
                'uuid' => uuid(),
                'user_id' => $user->id,
                'name' => "{$datum->name}'s Team",
                'personal_team' => true,
            ]);
        }
    }
}
