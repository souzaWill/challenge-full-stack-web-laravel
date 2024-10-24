<?php

namespace App\DTOs\Users;

use App\DTOs\BaseDTOInterface;
use App\Enums\RoleEnum;

class CreateUserDTO implements BaseDTOInterface
{
    public function __construct(
        public string $name,
        public string $email,
        public RoleEnum $role,
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;

    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['role'],
        );
    }
}
