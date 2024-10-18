<?php

namespace App\Services\Students;

use App\Models\Student;
use Illuminate\Support\Collection;

interface StudentServiceInterface
{
    public function list(): Collection;

    public function create(array $data): Student;

    public function update(int|Student $student, array $data): Student;

    public function delete(int|Student $student): bool;
}
