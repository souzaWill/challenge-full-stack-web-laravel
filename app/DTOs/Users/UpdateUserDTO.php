<?php

namespace App\DTOs\Users;

use App\DTOs\BaseDTOInterface;

class UpdateUserDTO implements BaseDTOInterface
{
    public function __construct(
        public string $name,
        public string $email,
    ) {
        $this->name = $name;
        $this->email = $email;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
        );
    }
}
