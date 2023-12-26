<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\{User, UsersTypes, UserType, Rate, UsersRate};


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RateSeeder::class,
            UserTypeSeeder::class,
            AdminSeeder::class
        ]);

    }
}
