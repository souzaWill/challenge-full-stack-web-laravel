<?php

namespace App\Repositories;

use App\DTOs\BaseDTOInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection|LengthAwarePaginator
    {
        return $this->model->all();;
    }

    public function find($id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(BaseDTOInterface $data): Model
    {
        return $this->model->create($data->toArray());
    }

    public function update($id, BaseDTOInterface $data): Model
    {
        $item = $this->find($id);
        $item->update($data->toArray());

        return $item;
    }

    public function delete($id): bool
    {
        $item = $this->find($id);

        return $item->delete();
    }
}
