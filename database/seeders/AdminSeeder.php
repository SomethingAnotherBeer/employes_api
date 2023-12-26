<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User, UsersTypes, UserType};
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_params = [
            'name' => 'administrator',
            'email' => 'administrator@employee.com',
            'password' => 'admin111',
        ];


        $admin = User::create([
            'name' => $admin_params['name'],
            'email' => $admin_params['email'],
            'password' => Hash::make($admin_params['password']),
        ]);


        $type = UserType::where('user_type_name', 'admin')->first();

        UsersTypes::create([
            'user_id' => $admin->id,
            'user_type_id' => $type->id,
        ]);


    }
}
