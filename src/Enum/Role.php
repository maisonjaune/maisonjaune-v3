<?php

namespace App\Enum;

enum Role: string
{
    case ROLE_USER = "ROLE_USER";

    case ROLE_ADMIN = "ROLE_ADMIN";

    case ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";
}
