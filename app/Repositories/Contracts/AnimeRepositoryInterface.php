<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AnimeRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator;
    public function all(): Collection;
    public function find(int $id);
    public function create(array $data);
    public function update($model, array $data);
    public function delete($model): bool;
    public function getRecentes(): Collection;
    public function getPopulares(): Collection;
}
