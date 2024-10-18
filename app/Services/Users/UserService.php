<?php

namespace App\Services\Users;

use App\DTOs\Users\UserDTO;
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
        $userDTO = UserDTO::fromArray($data);

        return $this->userRepository->create($userDTO);
    }

    public function update(int|User $user, array $data)
    {
        $user = $user instanceof User
            ? $user
            : $this->userRepository->find($user);

        $userDTO = UserDTO::fromArray([
            ...$data,
            'role' => $user->role,
        ]);

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
