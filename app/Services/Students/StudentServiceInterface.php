<?php

namespace App\Services\Students;

use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface StudentServiceInterface
{
    public function list(?int $itensPerPage = null): Collection|LengthAwarePaginator;

    public function findByUserName(string $search) : Collection|LengthAwarePaginator;

    public function create(array $data): Student;

    public function update(int|Student $student, array $data): Student;

    public function delete(int|Student $student): bool;
}
