<?php

namespace App\Services\Students;

use App\DTOs\Students\StudentDTO;
use App\DTOs\Users\UserDTO;
use App\Enums\RoleEnum;
use App\Models\Student;
use App\Repositories\Students\StudentRepositoryInterface;
use App\Services\Users\UserServiceInterface;
use Illuminate\Support\Collection;

class StudentService  implements StudentServiceInterface {
    public function __construct(
        protected StudentRepositoryInterface $studentRepository,
        protected UserServiceInterface $userService
    )
    {
        $this->studentRepository = $studentRepository;
        $this->userService = $userService;

    }

    public function list(): Collection
    {
        return $this->studentRepository->all();
    }

    public function create(array $data): Student
    {
        $userData = [
            'name' => $data['name'],
            'email'=> $data['email'],
            'role' => RoleEnum::Student,
        ];

        $user = $this->userService->create($userData);

        $studentDTO = StudentDTO::fromArray([
            ...$data, 
            'user_id' => $user->id
        ]);
        
        return $this->studentRepository->create($studentDTO);
    }
}
