<?php

namespace App\Services\Students;

use App\DTOs\Students\StudentDTO;
use App\Enums\RoleEnum;
use App\Models\Student;
use App\Repositories\Students\StudentRepositoryInterface;
use App\Services\Users\UserServiceInterface;
use Illuminate\Support\Collection;

class StudentService implements StudentServiceInterface
{
    public function __construct(
        protected StudentRepositoryInterface $studentRepository,
        protected UserServiceInterface $userService
    ) {
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
            'email' => $data['email'],
            'role' => RoleEnum::Student,
        ];

        $user = $this->userService->create($userData);

        $studentDTO = StudentDTO::fromArray([
            ...$data,
            'user_id' => $user->id,
        ]);

        return $this->studentRepository->create($studentDTO);
    }

    public function update(int|Student $student, array $data): Student
    {

        $student = $student instanceof Student
            ? $student
            : $this->studentRepository->find($student);

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        $this->userService->update(
            $student->user,
            $userData
        );

        return $student;

    }

    public function delete(int|Student $student): bool
    {
        $student = $student instanceof Student
            ? $student
            : $this->studentRepository->find($student);

        $deletedStudent = $this->studentRepository->delete(
            $student->id,
        );

        $deletedUser = $this->userService->delete(
            $student->user,
        );

        return $deletedStudent && $deletedUser;
    }
}
