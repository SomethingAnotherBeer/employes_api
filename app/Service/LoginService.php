<?php
namespace App\Service;
use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Hash;

use App\Models\{User, UserType, UsersTypes};
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginService
{
    use ValidationHelper;

    public function login(array $user_params): array
    {
        $rules = [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],

        ];

        $this->validateParams($user_params, $rules);

        $user = User::where('email', $user_params['email'])->first();

        if (!$user) {
            throw new HttpException(401, "Неправильный логин или пароль");
        }

        if (!Hash::check($user_params['password'], $user->password)) {
            throw new HttpException(401, "Неправильный логин или пароль");
        }

        $user_statuses = $this->getUserStatuses($user);

        $token = $user->createToken('user_token', $user_statuses);

        return ['auth_token' => $token->plainTextToken];


    }

    
    private function getUserStatuses(User $user): array
    {
        $available_statuses = ['amdin' => 'is_admin', 'employee' => 'is_employee'];
        $user_statuses = [];

        $user_types = UserType::join('users_types', 'user_types.id', '=', 'users_types.user_type_id')
                        ->join('users', 'users_types.user_id', '=', 'users.id')
                        ->where('users.id', $user->id)->get();

        foreach ($user_types as $userType) {
           if (array_key_exists($userType->user_type_name, $available_statuses)) {
                $user_statuses[] = $available_statuses[$userType->user_type_name];
           }
        }
    
        return $user_statuses;

    }




}