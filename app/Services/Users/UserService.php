<?php

namespace App\Services\Users;

use App\DTOs\Users\UpdateUserDTO;
use App\DTOs\Users\CreateUserDTO;
use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function create(array $data)
    {
        $userDTO = CreateUserDTO::fromArray($data);

        return $this->userRepository->create($userDTO);
    }

    public function update(int|User $user, array $data)
    {
        $user = $user instanceof User
            ? $user
            : $this->userRepository->find($user);

        $userDTO = UpdateUserDTO::fromArray($data);

        return $this->userRepository->update(
            $user->id,
            $userDTO
        );

    }

    public function delete(int|User $user): bool
    {
        return $this->userRepository->delete(
            $user->id,
        );
    }
}
