<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;
use App\Services\ComentariosService;
use App\Http\Requests\StoreComentarioRequest;

class ComentariosController extends Controller
{
    public function __construct(ComentariosService $comentariosService)
    {
        $this->comentariosService = $comentariosService;
    }

    /**
     * @OA\Get(
     *     path="/comentarios",
     *     summary="Listar todos os comentários",
     *     description="Retorna uma lista de todos os comentários.",
     *     operationId="getComentarios",
     *     tags={"Comentários"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de comentários retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Comentario")
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
        $comentarios = $this->comentariosService->listarTodos();
        return response()->json($comentarios);
    }
    /**
     * @OA\Post(
     * path="/comentarios",
     * tags={"Comentários"},
     * summary="Cria um novo comentário.",
     * description="Registra um novo comentário no banco de dados com base nos dados fornecidos.",
     * @OA\RequestBody(
     * required=true,
     * description="Dados do comentário a ser criado.",
     * @OA\JsonContent(
     * required={"user_id", "anime_id", "content"},
     * @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário que criou o comentário."),
     * @OA\Property(property="anime_id", type="integer", example=1, description="ID do anime ao qual o comentário se refere."),
     * @OA\Property(property="content", type="string", example="ótimo anime!", description="Conteúdo do comentário.")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Comentário criado com sucesso.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=10),
     * @OA\Property(property="user_id", type="integer", example=1),
     * @OA\Property(property="anime_id", type="integer", example=1),
     * @OA\Property(property="content", type="string", example="ótimo anime!"),
     * @OA\Property(property="created_at", type="string", format="date-time"),
     * @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erro de validação.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="O campo user_id é obrigatório."),
     * @OA\Property(property="errors", type="object",
     * @OA\AdditionalProperties(type="array", @OA\Items(type="string", example="O campo user_id é obrigatório."))
     * )
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Erro interno do servidor."
     * )
     * )
     */
    public function create(StoreComentarioRequest $request)
    {
        $comentario = $this->comentariosService->criar($request->validated());
        event(new \App\Events\ComentarioCriado($comentario));
        return response()->json($comentario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $comentario = $this->comentariosService->buscarPorId($id);
        if (!$comentario) {
            return response()->json(['message' => 'Comentário não encontrado'], 404);
        }
        return response()->json($comentario);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComentarioRequest $request, Comentarios $comentario)
    {
        $comentarioAtualizado = $this->comentariosService->atualizar($comentario, $request->validated());
        return response()->json($comentarioAtualizado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentarios $comentarios)
    {
        $deletado = $this->comentariosService->deletar($comentarios);
        if (!$deletado) {
            return response()->json(['message' => 'Comentário nao encontrado'], 404);
        }
        return response()->json(null, 204);
    }
}
