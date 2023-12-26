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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $user_types = ['admin', 'employee'];
        $rates = 
        [
            ['rate_slug' => 'per_hour', 'rate_name' => 'Почасовая ставка'],
            ['rate_slug' => 'per_week', 'rate_name' => 'Недельная ставка'],
        ];

        $user_params = [
            'name' => 'administrator',
            'email' => 'administrator@employes.com',
            'password' => '12345qqq',
            'type' => 'admin',
        ];



        foreach ($user_types as $user_type) {
           UserType::create([
                'user_type_name' => $user_type,
           ]);
        }

        foreach ($rates as $rate) {
            Rate::create([
                'rate_slug' => $rate['rate_slug'],
                'rate_name' => $rate['rate_name'],
            ]);
        }

        $user = User::factory()->create([
            'name' => $user_params['name'],
            'email' => $user_params['email'],
            'password' => $user_params['password'],
        ]);

        $admin_type =  UserType::where('user_type_name', 'admin')->first();

        UsersTypes::create([
            'user_id' => $user->id,
            'user_type_id' => $admin_type->id,
        ]);


    }
}
