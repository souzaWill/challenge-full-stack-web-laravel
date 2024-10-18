<?php

namespace App\DTOs;

interface BaseDTOInterface
{
    public function toArray(): array;

    public static function fromArray(array $data): self;
}
