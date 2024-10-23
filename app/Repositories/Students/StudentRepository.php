<?php

namespace App\Repositories\Students;

use App\Models\Student;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }

    public function paginate(int $ItensPerPage): LengthAwarePaginator
    {
        return $this->model->paginate($ItensPerPage);
    }

    public function findByUserName(string $name, int $itensPerPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->whereHas('user', function ($userQuery) use ($name) {
                return $userQuery->where('name', 'like', "%$name%");
            })->paginate($itensPerPage);

    }
}
