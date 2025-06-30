<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    }
    /**
     * Exibe os detalhes de uma categoria específica a partir da id fornecida na requisição.
     *
     * @param int $id A id da categoria que será exibida.
     *
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com os detalhes da categoria e status 200 em caso de sucesso.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Se a categoria com a id fornecida não for encontrada.
     */
    public function show($id)
    {

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
    public function create(Request $request)
    {
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
    public function delete(Request $request)
    {
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
    public function update(Request $request)
    {
    }
}
