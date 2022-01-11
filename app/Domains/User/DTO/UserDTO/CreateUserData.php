<?php

namespace App\Domains\User\DTO\UserDTO;

use Spatie\DataTransferObject\DataTransferObject;

class CreteUserData extends DataTransferObject
{
    stringpublic $first_name;
    stringpublic $last_name;
    stringpublic $email;
    stringpublic $password;
    ?intpublic $role;
}
