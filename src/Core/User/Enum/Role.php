<?php

declare(strict_types=1);

namespace App\Core\User\Enum;

use App\Core\Common\Enum\AbstractEnum;

class Role extends AbstractEnum
{
    public const ADMIN = 'ROLE_ADMIN';
    public const USER  = 'ROLE_USER';
    public const OPERATOR  = 'ROLE_OPERATOR';

    public const LIBRARIAN = 'ROLE_LIBRARIAN';
    public const READER = 'ROLE_READER';
}
