<?php

namespace App\Domains\User\Actions;

use Illuminate\Support\Facades\Hash;
use App\Domains\User\DTO\UserDTO\CreateUserData;
use App\Domains\User\Models\User;
use App\Domains\User\DTO\UserDTO\UpdateUserData;

class UserAction
{
    /**
     * create user
     * @param CreateUserData $data
     * @return mixed
     */
    public function create(CreateUserData $data)
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
            'role' => $data->role,
        ]);
    }

    public function update(UpdateUserData $data)
    {
        $user = User::find($data->id);
        abort_unless((bool)$user, 404, 'user not found');
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password ? Hash::make($data->password) : $user->password;
        $user->role = $data->role;
        $user->save();
        return $user;
    }
}
