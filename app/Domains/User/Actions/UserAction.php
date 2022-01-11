<?php

namespace App\Domains\User\Action;

use App\Domains\User\DTO\UserDTO\CreateUserData;
use App\Domains\User\Models\User;

class UserAction
{
    /**
     * create user
     *@param CreateUserData $data
     * @return mixed
     */
    public function create(CreateUserData $data)
    {
        return User::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'password' => $data->password,
            'role' => $data->role,
        ]);
    }
}
