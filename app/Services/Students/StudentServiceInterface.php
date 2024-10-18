<?php

namespace App\Services\Students;

use App\DTOs\Students\StudentDTO;
use App\DTOs\Users\UserDTO;
use App\Enums\RoleEnum;
use App\Models\Student;
use App\Repositories\Students\StudentRepositoryInterface;
use App\Services\Users\UserServiceInterface;
use Illuminate\Support\Collection;

interface StudentServiceInterface {

    public function list(): Collection;
    public function create(array $data);
}