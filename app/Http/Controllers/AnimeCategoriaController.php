<?php

namespace App\Http\Controllers;

use App\Models\AnimeCategoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class AnimeCategoriaController extends Controller
{
    use AuthorizesRequests;

    public function __construct(AnimeCategoria $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $paginacao = $request->query('por_pagina');
        if ($paginacao) {
            $categorias = $this->model->paginate($paginacao);
        } else {
            $categorias = $this->model->all();
        }

        return response()->json($categorias, Response::HTTP_OK);
    }

    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->model->findOrFail($id), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Anime-categoria nao encontrado'], Response::HTTP_NOT_FOUND);
        }
    }

}
