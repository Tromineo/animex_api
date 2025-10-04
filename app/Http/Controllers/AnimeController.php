<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimeRequest;
use App\Models\Anime;
use App\Services\AnimeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use app\Http\Requests\AnimeRequest;
use App\Http\Requests\DestroyAnimeRequest;
use App\Http\Requests\UpdateAnimeRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use ModelNotFoundException;
use App\Http\Requests\AddCategoriaRequest;
use App\Models\AnimeCategoria;
use PHPMD\Renderer\JSONRenderer;

class AnimeController extends Controller
{
    use AuthorizesRequests;

    protected $animeService;

    public function __construct(AnimeService $animeService)
    {
        $this->animeService = $animeService;
    }

    /**
     * @OA\Get(
     * path="/animes",
     * tags={"Animes"},
     * summary="Retorna uma lista de animes com ou sem paginação.",
    * description="Este endpoint pode retornar todos os animes ou uma lista paginada, dependendo do parâmetro 'por_pagina'. Exemplo de requisição curl: curl -X GET http://127.0.0.1:8000/api/animes -H Authorization:Bearer SEU_TOKEN",
     * @OA\Parameter(
     * name="por_pagina",
     * in="query",
     * description="Número de itens por página para a paginação.",
     * required=false,
     * @OA\Schema(
     * type="integer",
     * format="int64"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Lista de animes retornada com sucesso.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="titulo", type="string", example="Naruto"),
     * @OA\Property(property="genero", type="string", example="Aventura, Ação"),
     * @OA\Property(property="episodios", type="integer", example=500)
     * )
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function index(Request $request)
    {
        $paginacao = $request->query('por_pagina');
        $animes = $this->animeService->listarTodos($paginacao);
        return response()->json($animes, Response::HTTP_OK);
    }
    /**
     * @OA\Get(
     * path="/animes/{id}",
     * tags={"Animes"},
     * summary="Retorna um anime específico pelo ID.",
    * description="Recupera os detalhes de um único anime usando o seu ID como parâmetro de rota. Exemplo de requisição curl: curl -X GET http://127.0.0.1:8000/api/animes/1 -H Authorization:Bearer SEU_TOKEN",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID do anime que será retornado.",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Detalhes do anime retornados com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="titulo", type="string", example="Naruto"),
     * @OA\Property(property="genero", type="string", example="Aventura, Ação"),
     * @OA\Property(property="episodios", type="integer", example=500)
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Anime não encontrado.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Anime não encontrado")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $anime = $this->animeService->buscarPorId($id);
        if (!$anime) {
            return response()->json(['message' => 'Anime não encontrado'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($anime, Response::HTTP_OK);
    }

        /**
     * @OA\Post(
     * path="/animes",
     * tags={"Animes"},
     * summary="Cria um novo anime.",
     * description="Cria um novo registro de anime no banco de dados com base nos dados fornecidos.",
     * @OA\RequestBody(
     * required=true,
     * description="Dados do anime a ser criado.",
     * @OA\JsonContent(
     * @OA\Property(property="titulo", type="string", example="Demon Slayer"),
     * @OA\Property(property="genero", type="string", example="Ação, Fantasia"),
     * @OA\Property(property="episodios", type="integer", example=26, description="Número de episódios (opcional)"),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Anime criado com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=2),
     * @OA\Property(property="titulo", type="string", example="Demon Slayer"),
     * @OA\Property(property="genero", type="string", example="Ação, Fantasia"),
     * @OA\Property(property="episodios", type="integer", example=26)
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Os dados fornecidos são inválidos."),
     * @OA\Property(property="errors", type="object",
     * @OA\AdditionalProperties(type="array", @OA\Items(type="string", example="O campo titulo é obrigatório."))
     * )
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function create(StoreAnimeRequest $request): JsonResponse
    {
        $anime = $this->animeService->criar($request->validated());
        return response()->json($anime, 201);
    }
    /**
     * @OA\Delete(
     * path="/animes/{id}",
     * tags={"Animes"},
     * summary="Deleta um anime pelo ID.",
     * description="Remove um anime específico do banco de dados, se o usuário tiver permissão.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID do anime a ser excluído.",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Anime excluído com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Anime excluido com sucesso")
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Ação não autorizada.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Você não tem permissão para excluir este anime.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Anime não encontrado.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Anime não encontrado")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function delete(DestroyAnimeRequest $request, Anime $anime): JsonResponse
    {
        $this->animeService->deletar($anime);
        return response()->json(['message' => 'Anime excluido com sucesso'], 200);
    }
    /**
     * @OA\Put(
     * path="/animes/{id}",
     * tags={"Animes"},
     * summary="Atualiza um anime existente.",
     * description="Atualiza os dados de um anime específico no banco de dados. A requisição exige que o usuário tenha permissão para realizar a ação.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID do anime a ser atualizado.",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Dados do anime para atualização.",
     * @OA\JsonContent(
     * @OA\Property(property="titulo", type="string", example="Demon Slayer: Kimetsu no Yaiba"),
     * @OA\Property(property="genero", type="string", example="Ação, Fantasia"),
     * @OA\Property(property="episodios", type="integer", example=26),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Anime atualizado com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="titulo", type="string", example="Demon Slayer: Kimetsu no Yaiba"),
     * @OA\Property(property="genero", type="string", example="Ação, Fantasia"),
     * @OA\Property(property="episodios", type="integer", example=26)
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Ação não autorizada. O usuário não tem permissão para atualizar este anime.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Este usuário não está autorizado a realizar esta ação.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Anime não encontrado.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Anime não encontrado")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação. Os dados fornecidos são inválidos.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Os dados fornecidos são inválidos."),
     * @OA\Property(property="errors", type="object",
     * @OA\AdditionalProperties(type="array", @OA\Items(type="string", example="O campo titulo é obrigatório."))
     * )
     * )
     * )
     * )
     */
    public function update(UpdateAnimeRequest $request, Anime $anime): JsonResponse
    {
        $this->authorize('update', $anime);
        $animeAtualizado = $this->animeService->atualizar($anime, $request->validated());
        return response()->json($animeAtualizado);
    }
        /**
     * @OA\Post(
     * path="/animes/{animeId}/vincular-categoria",
     * tags={"Animes"},
     * summary="Vincula uma categoria a um anime.",
     * description="Associa uma categoria existente a um anime específico. O ID do anime é passado na URL, e o ID da categoria é enviado no corpo da requisição.",
     * @OA\Parameter(
     * name="animeId",
     * in="path",
     * description="ID do anime ao qual a categoria será vinculada.",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="ID da categoria a ser vinculada.",
     * @OA\JsonContent(
     * required={"categoria_id"},
     * @OA\Property(property="categoria_id", type="integer", format="int64", example=5, description="ID da categoria.")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Categoria vinculada com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Categoria vinculada com sucesso."),
     * @OA\Property(property="anime_categoria", type="object",
     * @OA\Property(property="anime_id", type="integer", example=1),
     * @OA\Property(property="categoria_id", type="integer", example=5),
     * @OA\Property(property="categoria", type="object", description="Detalhes da categoria vinculada."),
     * @OA\Property(property="created_at", type="string", format="date-time"),
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Anime ou Categoria não encontrados.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Anime ou categoria não encontrados.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="O campo categoria_id é obrigatório.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function vincularCategoria(Request $request, $animeId)
    {
        $animeCategoria = new AnimeCategoria();
        $animeCategoria->anime_id = $animeId;
        $animeCategoria->categoria_id = $request->categoria_id;
        $animeCategoria->save();

        return response()->json([
            'message' => 'Categoria vinculada com sucesso.',
            'anime' => $animeCategoria->load('categoria')
        ], 200);
    }

}
