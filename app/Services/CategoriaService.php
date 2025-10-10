<?php

namespace App\Services;

use App\Models\Categoria;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoriaService
{
    public function listarTodos($porPagina = null)
    {
        if ($porPagina) {
            return Categoria::paginate($porPagina);
        }
        return Categoria::all();
    }

    public function buscarPorId($id)
    {
        return Categoria::find($id);
    }

    public function criar(array $dados)
    {
        return Categoria::create($dados);
    }

    public function atualizar(Categoria $categoria, array $dados)
    {
        $categoria->update($dados);
        return $categoria;
    }

    public function deletar(Categoria $categoria)
    {
        $categoria->delete();
        return true;
    }
}
