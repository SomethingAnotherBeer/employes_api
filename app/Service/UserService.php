<?php
namespace App\Service;
use App\Helpers\ValidationHelper;
use App\Models\User;

use App\Exceptions\User\UserAlreadyExistsException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ValidationHelper;


    public function createUser(array $user_params): User
    {
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];

        $this->validateParams($user_params, $rules);

        if (User::where('email', $user_params['email'])->first()) {
            throw new UserAlreadyExistsException("Данный пользователь уже существует в системе");
        }


        $user = User::create([
            'name' => $user_params['name'],
            'email' => $user_params['email'],
            'password' => Hash::make($user_params['password']),
        ]);


       return $user;
    }

}