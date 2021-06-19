<?php

declare(strict_types=1);

namespace App\Core\User\Factory;

use App\Core\User\Document\User;

class UserFactory
{
    public function create(
        string $phone,
        array $roles,
        ?string $apiToken = null
    ): User {
        $user = new User(
            $phone,
            $roles,
            $apiToken
        );

        return $user;
    }
}
