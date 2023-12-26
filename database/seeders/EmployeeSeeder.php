<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User, UserType, UsersTypes};
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employes_params = [
            ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'],
            ['name' => 'Marcus Miller', 'email' => 'marcusmiller@employee.com', 'password' => '222'],
        ];

        $type = UserType::where('user_type_name', 'employee');

        foreach ($employes_params as $employee_params){
            $currentEmployee  = User::create([
                'name' => $employee_params['name'],
                'email' => $employee_params['email'],
                'password' => Hash::make($employee_params['password']),
            ]);

            UsersTypes::create([
                'user_id' => $currentEmployee->id,
                'user_type_id' => $type->id,
            ]);

            
        }

    }
}
