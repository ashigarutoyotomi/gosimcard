<?php

namespace App\Domains\User\DTO\UserDTO;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateUserData extends DataTransferObject
{
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $password;
    public int $role;
    public int $id;
}
