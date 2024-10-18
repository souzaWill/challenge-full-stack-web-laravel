<?php

namespace App\Services\Users;

use App\DTOs\Users\UserDTO;
use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;

class UserService implements UserServiceInterface {
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    )
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data) 
    {
        $userDTO = UserDTO::fromArray($data);

        return $this->userRepository->create($userDTO);
    }
}