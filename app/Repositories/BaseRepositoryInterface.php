<?php

namespace App\Repositories;

use App\DTOs\BaseDTOInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Model;

    public function create(BaseDTOInterface $data): Model;

    public function update(int $id, BaseDTOInterface $data): Model;

    public function delete(int $id): bool;
}
