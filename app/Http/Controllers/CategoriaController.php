<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyAnimeRequest;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\DestroyCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Http\jsonResponse;

class CategoriaController extends Controller
{
    public function __construct()
    {
        //
    }
    /**
     * Retorna todas as categorias presentes na base de dados.
     *
     * @return JsonResponse A resposta JSON com as categorias.
     */
    public function index()
    {
        return response()->json(Categoria::all());
    }
    /**
     * Exibe os detalhes de uma categoria específica a partir da id fornecida na requisição.
     *
     * @param int $id A id da categoria que será exibida.
     *
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com os detalhes da categoria e status 200 em caso de sucesso.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Se a categoria com a id fornecida não for encontrada.
     * 
     * 
     * @OA\Get(
     * path="/categorias/{id}",
     * summary="Retorna uma categoria específica",
     * description="Retorna os dados de uma categoria buscando pelo seu ID.",
     * tags={"Categoria"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID da categoria",
     * required=true,
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Dados da categoria retornado com sucesso.",
     * @OA\JsonContent(ref="#/components/schemas/Categoria")     
     * ),
     * @OA\Response(
     * response=404,
     * description="Categoria nao encontrada",
     * @OA\JsonContent(ref="#/components/schemas/NotFound")
     * )
     * )
     */
    public function show($id)
    {
        return response()->json(Categoria::find($id));
    }
    /**
     * Cria uma nova categoria.
     *
     * @param \Illuminate\Http\Request $request A requisição HTTP.
     *
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com a categoria criada e status 201 em caso de sucesso.
     *
     * @throws \Illuminate\Validation\ValidationException Se os dados de entrada n o forem v lidos.
     */
    public function create(StoreCategoriaRequest $request)
    {
        return response()->json(Categoria::create($request->validated()), 201);

    }
    /**
     * Exclui uma categoria específica a partir de uma Id fornecida na requisição.
     *
     * @param \Illuminate\Http\Request $request A requisição contendo a Id da categoria a ser excluído.
     *      - 'id': integer, obrigatório. A id da categoria que será excluído.
     *
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com a Id da categoria excluído e status 200 em caso de sucesso, ou false e status 204 se o ID não for válido.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Se a categoria com a Id fornecido não for encontrado.
     */
    public function delete(DestroyCategoriaRequest $request)
    {
        return response()->json(Categoria::destroy($request->id));
    }
    /**
     * Atualiza uma categoria existente.
     *
     * @param \Illuminate\Http\Request $request A requisição contendo os dados para atualização. Deve incluir os seguintes campos:
     *      - 'nome': string, opcional, máximo de 255 caracteres.
     *
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com a categoria atualizada e status 200 em caso de sucesso.
     *
     * @throws \Illuminate\Validation\ValidationException Se os dados de entrada não forem válidos.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Se a categoria com o ID fornecido não for encontrada.
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
