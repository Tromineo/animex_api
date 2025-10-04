<?php

namespace App\Services;

use App\Models\Anime;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AnimeService
{
    public function listarTodos($porPagina = null)
    {
        if ($porPagina) {
            return Anime::paginate($porPagina);
        }
        return Anime::all();
    }

    public function buscarPorId($id)
    {
        return Anime::find($id);
    }

    public function criar(array $dados)
    {
        return Anime::create($dados);
    }

    public function atualizar(Anime $anime, array $dados)
    {
        $anime->update($dados);
        return $anime;
    }

    public function deletar(Anime $anime)
    {
        $anime->delete();
        return true;
    }
}
