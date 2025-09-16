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

/**
 * @OA\Get(
 *     path="/anime-categorias/{id}",
 *     summary="Exibir um anime-categoria pelo ID",
 *     description="Retorna um objeto de anime-categoria pelo seu ID",
 *     operationId="showAnimeCategoria",
 *     tags={"AnimeCategorias"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID do anime-categoria",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Anime-categoria encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             example={"id": 1, "anime_id": 10, "categoria_id": 2}
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Anime-categoria não encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             example={"message": "Anime-categoria nao encontrado"}
 *         )
 *     )
 * )
 */
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json($this->model->findOrFail($id), Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Anime-categoria nao encontrado'], Response::HTTP_NOT_FOUND);
        }
    }


}
