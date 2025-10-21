<?php

namespace App\Services;

use App\Models\Comentarios;

class ComentariosService
{
    public function listarTodos()
    {
        return Comentarios::all();
    }

    public function criar(array $dados)
    {
        return Comentarios::create($dados);
    }

    public function buscarPorId(int $id)
    {
        return Comentarios::find($id);
    }

    public function deletar(Comentarios $comentario)
    {
        if (!$comentario->exists) {
            return false;
        }
        $comentario->delete();
        return true;
    }
}
