<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User, HoursTransaction};


class HoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dates = ['2023-12-18', '2023-12-19', '2023-12-20', '2023-12-21', '2023-12-22'];


        $employes = User::join('users_types', 'employee.id', '=', 'users_types.user_id')
                ->join('user_types', 'users_types.user_type_id', '=', 'users_type.id')
                ->where('user_types.user_type_name', 'employee')
                ->get();


         foreach ($dates as $date) {

            foreach ($employes as $employee) {
                HoursTransaction::create([
                    'user_id' => $employee->id,
                    'worked_hours' => rand(4, 12),
                    'is_done' => false,
                    'hours_transaction_created' => $date,
                ]);
            }
            
         }       

    }
}
