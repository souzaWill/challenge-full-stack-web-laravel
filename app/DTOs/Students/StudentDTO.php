<?php

namespace App\DTOs\Students;

use App\DTOs\BaseDTOInterface;

class StudentDTO implements BaseDTOInterface
{
    
    public function __construct(
        public int $userId,
        public string $document,
        public string $registrationNumber,
    )
    {
        $this->userId = $userId;
        $this->document = $document;
        $this->registrationNumber = $registrationNumber;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'document' => $this->document,
            'registration_number' => $this->registrationNumber,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['document'],
            $data['registration_number'],
        );
    }
}
