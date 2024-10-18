<?php

namespace App\Services\Users;

use App\Models\User;

interface UserServiceInterface
{
    public function create(array $data);

    public function update(int|User $user, array $data);

    public function delete(int|User $user): bool;
}
