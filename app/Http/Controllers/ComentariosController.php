<?php

namespace App\Http\Controllers;

use App\Models\Comentarios;
use Illuminate\Http\Request;
use App\Services\ComentariosService;
use App\Http\Requests\StoreComentarioRequest;

class ComentariosController extends Controller
{

    public function __construct(ComentariosService $comentariosService){
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
     * Show the form for creating a new resource.
     */
    public function create(StoreComentarioRequest $request)
    {
        $comentario = $this->comentariosService->criar($request->validated());
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
