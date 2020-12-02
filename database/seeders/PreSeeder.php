<?php

namespace Database\Seeders;

use App\Concerns\Seeds\SeedingProgressBar;
use Illuminate\Database\Seeder;

class PreSeeder extends Seeder
{
    use SeedingProgressBar;

    public $seeders = [
        \Database\Seeders\PermissionSeeder::class,
        \Database\Seeders\SuperUserSeeder::class,
    ];
}
