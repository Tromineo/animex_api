<?php

namespace App\Repositories;

use App\Models\Work;
use App\Repositories\Contracts\AnimeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentAnimeRepository implements AnimeRepositoryInterface
{
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Work::paginate($perPage);
    }

    public function all(): Collection
    {
        return Work::all();
    }

    public function find(int $id)
    {
        return Work::find($id);
    }

    public function create(array $data)
    {
        return Work::create($data);
    }

    public function update($model, array $data)
    {
        return $model->update($data) ? $model : null;
    }

    public function delete($model): bool
    {
        return (bool) $model->delete();
    }
    public function getRecentes(): Collection
    {
        $semanaPassada = now()->subWeek();
        return Work::where('created_at', '>=', $semanaPassada)->get();
    }
    public function getPopulares(): Collection
    {
        return Work::orderBy('visualizacoes', 'desc')->take(10)->get();
    }
}
