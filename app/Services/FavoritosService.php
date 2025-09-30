<?php

namespace App\Services;

use App\Models\Favoritos;

class FavoritosService
{
    public function listarTodos()
    {
        return Favoritos::all();
    }

    public function criar(array $dados)
    {
        return Favoritos::create($dados);
    }

    public function buscarPorId(int $id)
    {
        return Favoritos::find($id);
    }

    public function atualizar(Favoritos $favorito, array $dados)
    {
        $favorito->update($dados);
        return $favorito;
    }

    public function deletar(Favoritos $favorito)
    {
        if (!$favorito->exists) {
            return false;
        }
        $favorito->delete();
        return true;
    }
}
