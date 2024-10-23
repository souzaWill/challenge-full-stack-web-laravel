<?php

namespace App\Repositories\Students;

use App\Repositories\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface StudentRepositoryInterface extends BaseRepositoryInterface {

    public function paginate(int $ItensPerPage): LengthAwarePaginator;

    public function findByUserName(string $name): LengthAwarePaginator;

}
