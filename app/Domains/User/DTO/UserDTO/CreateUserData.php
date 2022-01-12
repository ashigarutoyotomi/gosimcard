<?php

namespace App\Domains\User\DTO\UserDTO;

use Spatie\DataTransferObject\DataTransferObject;

class CreteUserData extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $password;
    public ?int $role;
}
