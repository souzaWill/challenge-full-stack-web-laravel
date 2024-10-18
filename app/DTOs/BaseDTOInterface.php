<?php

namespace App\DTOs;

interface BaseDTOInterface
{
    public function toArray(): array;

    public function fromArray(array $data): self;
}
