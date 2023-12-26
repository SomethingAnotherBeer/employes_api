<?php
namespace Tests\Feature\Trait;
use App\Models\{User, UsersTypes, UserType};
use Illuminate\Support\Facades\Hash;

trait EmployeeTrait
{
    protected function createEmployee(array $employee_params):User
    {
        $employee = User::create([
            'name' => $employee_params['name'],
            'email' => $employee_params['email'],
            'password' =>  Hash::make($employee_params['password']),
        ]);
        
        $type = UserType::where('user_type_name', 'employee')->first();
        UsersTypes::create([
            'user_id' => $employee->id,
            'user_type_id' => $type->id,
        ]);


        return $employee;

    }


}