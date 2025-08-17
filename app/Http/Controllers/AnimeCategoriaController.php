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

    /**
     * Retorna todos os animes_categorias presentes na base de dados.
     *
     * A resposta pode ser paginada. Se a query string "por_pagina" for passada, a resposta
     * retorna os animes paginados com o valor especificado. Caso n o seja passado, a resposta
     * retorna todos as relações categoria~anime.
     *
     * @param Request $request A requisição o HTTP.
     *
     * @return JsonResponse A resposta JSON com as relações categoria~anime.
     *
     * @OA\Get(
     * path="/animes-categorias",
     * summary="Retorna uma lista das relações categoria~anime",
     * description="Retorna uma lista das relações categoria~anime. É possível paginar a lista passando o parâmetro 'por_pagina' na query.",
     * tags={"AnimesCategorias"},
     * @OA\Parameter(
     * name="por_pagina",
     * in="query",
     * description="Número de itens por página",
     * required=false,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Lista de animes-categorias retornada com sucesso.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/AnimesCategorias")
     * )
     * )
     * )
    */
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
    * Exibe os detalhes de um objeto animê-categoria específico a partir da id fornecida na requisição.
    *
    * @param int $id A id do animê-caregoria que será exibido.
    *
    * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com os detalhes do anime-categoria e status 200 em caso de sucesso.
    *
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Se o animê-categoria com a id fornecida não for encontrado.
    *
    *
     * @OA\Get(
     * path="/animes/{id}",
     * summary="Retorna um anime-caregoria específico",
     * description="Retorna os dados de um anime-categoria buscando pelo seu ID.",
     * tags={"AnimeCategoria"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID do anime-categoria a ser retornado",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Dados do anime-categoria retornado com sucesso.",
     * @OA\JsonContent(ref="#/components/schemas/Anime")
     * ),
     * @OA\Response(
     * response=404,
     * description="Anime-categoria não encontrado."
     * )
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
