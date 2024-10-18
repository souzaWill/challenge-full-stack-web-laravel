<?php

namespace App\Enums;

enum RoleEnum: int
{
    case Admin = 1;
    case Student = 2;

    public function label(): string
    {
        return match($this) {
            self::Admin => 'Admin',
            self::Student => 'Student',
        };
    }
}
