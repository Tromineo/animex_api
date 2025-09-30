<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoritoRequest;
use App\Http\Requests\UpdateFavoritosRequest;
use App\Http\Requests\DeleteFavoritosRequest;
use App\Models\Favoritos;
use App\Services\FavoritosService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritosController extends Controller
{
    protected $favoritosService;

    public function __construct(FavoritosService $favoritosService)
    {
        $this->favoritosService = $favoritosService;
    }
    /**
    * @OA\Get(
    *     path="/api/favoritos",
    *     summary="Listar todos os favoritos",
    *     description="Retorna uma lista de todos os itens favoritos.",
    *     operationId="getFavoritos",
    *     tags={"Favoritos"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de favoritos retornada com sucesso",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(ref="#/components/schemas/Favorito")
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Erro interno do servidor"
    *     )
    * )
    */
    public function index()
    {
        $favoritos = $this->favoritosService->listarTodos();
        return response()->json($favoritos);
    }

    /**
     * @OA\Post(
     *     path="/favoritos",
     *     summary="Adiciona um anime aos favoritos do usuário",
     *     description="Cria um novo registro de favorito usando os dados validados do request.",
     *     tags={"Favoritos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"user_id","anime_id"},
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário que está favoritando o anime"),
     *             @OA\Property(property="anime_id", type="integer", example=42, description="ID do anime a ser favoritado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Favorito criado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=123, description="ID do registro de favorito"),
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário"),
     *             @OA\Property(property="anime_id", type="integer", example=42, description="ID do anime"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-28T18:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The user_id field is required.")
     *                 ),
     *                 @OA\Property(
     *                     property="anime_id",
     *                     type="array",
     *                     @OA\Items(type="string", example="The anime_id field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function create(StoreFavoritoRequest $request): JsonResponse
    {
        $favorito = $this->favoritosService->criar($request->validated());
        return response()->json($favorito, 201);
    }
    

    /**
     * @OA\Get(
     *     path="/api/favoritos/{id}",
     *     summary="Exibe um favorito específico",
     *     description="Retorna os dados de um favorito pelo ID.",
     *     tags={"Favoritos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do favorito",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Favorito encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Favorito")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Favorito não encontrado"
     *     )
     * )
     */
    public function show(int $id)
    {
        $favorito = $this->favoritosService->buscarPorId($id);
        return response()->json($favorito);
    }


    /**
     * @OA\Patch(
     *     path="/api/favoritos/{id}",
     *     summary="Atualiza um favorito",
     *     description="Atualiza os dados de um favorito existente.",
     *     tags={"Favoritos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do favorito",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="anime_id", type="integer", example=42, description="Novo ID do anime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Favorito atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Favorito")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Favorito não encontrado"
     *     )
     * )
     */
    public function update(UpdateFavoritosRequest $request, Favoritos $favorito)
    {
        //usa policy
        $favoritoAtualizado = $this->favoritosService->atualizar($favorito, $request->validated());
        return response()->json($favoritoAtualizado, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/favoritos/{id}",
     *     summary="Remove um favorito",
     *     description="Remove um favorito do banco de dados pelo ID.",
     *     tags={"Favoritos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do favorito",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Favorito removido com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Favorito não encontrado"
     *     )
     * )
     */
    public function delete(DeleteFavoritosRequest $request, Favoritos $favorito)
    {
        //usa policy
        $deletado = $this->favoritosService->deletar($favorito);
        if (!$deletado) {
            return response()->json(['message' => 'Favorito nao encontrado'], 404);
        }
        return response()->json(null, 204);
    }
}
