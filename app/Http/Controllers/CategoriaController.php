<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoriaService;
use App\Http\Requests\DestroyAnimeRequest;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\DestroyCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Http\jsonResponse;

class CategoriaController extends Controller
{
    protected $categoriaService;
    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    /**
     * @OA\Get(
     * path="/categorias",
     * tags={"Categorias"},
     * summary="Lista todas as categorias.",
     * description="Retorna uma lista completa de todas as categorias de animes disponíveis no sistema.",
     * @OA\Response(
     * response=200,
     * description="Lista de categorias retornada com sucesso.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="nome", type="string", example="Aventura"),
     * @OA\Property(property="created_at", type="string", format="date-time"),
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function index()
    {
        return response()->json($this->categoriaService->listarTodos());
    }
    /**
     * @OA\Get(
     * path="/categorias/{id}",
     * tags={"Categorias"},
     * summary="Retorna uma categoria específica pelo ID.",
     * description="Recupera os detalhes de uma única categoria usando seu ID como parâmetro de rota. Retorna um objeto JSON da categoria ou 'null' se não for encontrada.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID da categoria que será retornada.",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Detalhes da categoria retornados com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="nome", type="string", example="Aventura"),
     * @OA\Property(property="created_at", type="string", format="date-time"),
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Nenhuma categoria encontrada para o ID fornecido (retorna 'null')."
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function show($id)
    {
        return response()->json($this->categoriaService->buscarPorId($id));
    }
    /**
     * @OA\Post(
     * path="/categorias",
     * tags={"Categorias"},
     * summary="Cria uma nova categoria.",
     * description="Registra uma nova categoria no banco de dados com base nos dados fornecidos.",
     * @OA\RequestBody(
     * required=true,
     * description="Dados da categoria a ser criada.",
     * @OA\JsonContent(
     * required={"nome"},
     * @OA\Property(property="nome", type="string", example="Ficção Científica", description="Nome da categoria.")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Categoria criada com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=10),
     * @OA\Property(property="nome", type="string", example="Ficção Científica"),
     * @OA\Property(property="created_at", type="string", format="date-time"),
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="O campo nome é obrigatório."),
     * @OA\Property(property="errors", type="object",
     * @OA\AdditionalProperties(type="array", @OA\Items(type="string", example="O campo nome é obrigatório."))
     * )
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function create(StoreCategoriaRequest $request, Categoria $categoria)
    {
        $categoriaCriada = $categoria->create($request->validated());

        return response()->json($categoriaCriada, 201);

    }
    /**
     * @OA\Delete(
     * path="/categorias/{id}",
     * tags={"Categorias"},
     * summary="Exclui uma categoria pelo ID.",
     * description="Remove uma categoria específica do banco de dados. A requisição exige que o usuário tenha permissão para realizar a ação.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID da categoria a ser excluída.",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Categoria excluída com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Recurso removido com sucesso."),
     * @OA\Property(property="deleted_count", type="integer", example=1, description="Número de registros excluídos.")
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Ação não autorizada.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Você não tem permissão para excluir esta categoria.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Categoria não encontrada.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Categoria não encontrada")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function delete(DestroyCategoriaRequest $request)
    {
        return response()->json($this->categoriaService->deletar($request->id));
    }
    /**
     * @OA\Put(
     * path="/categorias/{id}",
     * tags={"Categorias"},
     * summary="Atualiza uma categoria existente.",
     * description="Atualiza os dados de uma categoria específica no banco de dados. A requisição exige que o usuário tenha permissão para realizar a ação.",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID da categoria a ser atualizada.",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * example=1
     * )
     * ),
     * @OA\RequestBody(
     * required=true,
     * description="Dados da categoria para atualização.",
     * @OA\JsonContent(
     * @OA\Property(property="nome", type="string", example="Terror")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Categoria atualizada com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="nome", type="string", example="Terror"),
     * @OA\Property(property="created_at", type="string", format="date-time"),
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Ação não autorizada. O usuário não tem permissão para atualizar esta categoria.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Este usuário não está autorizado a realizar esta ação.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Categoria não encontrada.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Categoria não encontrada")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação. Os dados fornecidos são inválidos.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="O campo nome é obrigatório."),
     * @OA\Property(property="errors", type="object",
     * @OA\AdditionalProperties(type="array", @OA\Items(type="string", example="O campo nome é obrigatório."))
     * )
     * )
     * )
     * )
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria): JsonResponse
    {
        // 1. Autorização (usando Policy)
        // Isso verifica se o usuário autenticado tem permissão para atualizar esta categoria.
        $this->authorize('update', $categoria);

        $categoria->update($request->validated());

        return response()->json($categoria);
    }
}
