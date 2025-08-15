<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimeRequest;
use App\Models\Anime;
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

    public function __construct(Anime $anime)
    {
        $this->model = $anime;
    }
    /**
     * Retorna todos os animes presentes na base de dados.
     *
     * A resposta pode ser paginada. Se a query string "por_pagina" for passada, a resposta
     * retorna os animes paginados com o valor especificado. Caso n o seja passado, a resposta
     * retorna todos os animes.
     *
     * @param Request $request A requisi o HTTP.
     *
     * @return JsonResponse A resposta JSON com os animes.
     *
     * @OA\Get(
     * path="/animes",
     * summary="Retorna uma lista de animes",
     * description="Retorna uma lista de animes. É possível paginar a lista passando o parâmetro 'por_pagina' na query.",
     * tags={"Animes"},
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
     * description="Lista de animes retornada com sucesso.",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/Animes")
     * )
     * )
     * )
    */
    public function index(Request $request)
    {
        $paginacao = $request->query('por_pagina');
        if ($paginacao) {
            $animes = $this->model->paginate($paginacao);
        } else {
            $animes = $this->model->all();
        }

        return response()->json($animes, Response::HTTP_OK);
    }
    /**
    * Exibe os detalhes de um animê específico a partir da id fornecida na requisição.
    *
    * @param int $id A id do animê que será exibido.
    *
    * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com os detalhes do animê e status 200 em caso de sucesso.
    *
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Se o animê com a id fornecida não for encontrado.
    *
    *  
     * @OA\Get(
     * path="/animes/{id}",
     * summary="Retorna um anime específico",
     * description="Retorna os dados de um anime buscando pelo seu ID.",
     * tags={"Anime"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID do anime a ser retornado",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Dados do anime retornado com sucesso.",
     * @OA\JsonContent(ref="#/components/schemas/Anime")
     * ),
     * @OA\Response(
     * response=404,
     * description="Anime não encontrado."
     * )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try{
            $anime = $this->model->findOrFail($id);
            return response()->json($anime, Response::HTTP_OK);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Anime não encontrado'], Response::HTTP_NOT_FOUND);
        }
    }
    /**
     * Cria um novo animê com os dados recebidos.
     *
     * @param \Illuminate\Http\Request $request A requisição contendo os dados para criar um novo animê.
     * - 'titulo': string, obrigatório, máximo de 255 caracteres.
     * - 'genero': string, obrigatório, máximo de 255 caracteres.
     * - 'resumo': string, opcional, máximo de 255 caracteres.
     * - 'episodios': integer, obrigatório.
     * - 'lancamento': date, opcional.
     *
     * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com o animê criado e status 201 em caso de sucesso.
     *
     * @throws \Illuminate\Validation\ValidationException Se os dados de entrada não forem válidos.
     *
     * @OA\Post(
     * path="/animes",
     * tags={"Animes"},
     * summary="Cria um novo animê",
     * description="Cria um novo recurso de animê no banco de dados.",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/AnimeInput")
     * ),
     * @OA\Response(
     * response=201,
     * description="O animê foi criado com sucesso.",
     * @OA\JsonContent(ref="#/components/schemas/AnimeOutput")
     * ),
     * @OA\Response(
     * response=422,
     * description="Dados de entrada inválidos.",
     * @OA\JsonContent(ref="#/components/schemas/ValidationError")
     * )
     * )
     */
    public function create(StoreAnimeRequest $request): JsonResponse
    {
        $anime = Anime::create($request->validated());
        return response()->json($anime, 201);
    }
    /**
    * Exclui um animê específico a partir de uma Id fornecida na requisição. É softdelet.
    *
    * @param \Illuminate\Http\Request $request A requisição contendo a Id do animê a ser excluído.
    *      - 'id': integer, obrigatório. A id do animê que será excluído.
    *
    * @return \Illuminate\Http\JsonResponse Retorna uma resposta JSON com a Id do animê excluído e status 200 em caso de sucesso, ou false e status 204 se o ID não for válido.
    *
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Se o animê com a Id fornecido não for encontrado.
    *
    * @OA\Delete(
     * path="/animes",
     * tags={"Animes"},
     * summary="Delete um animê específico",
     * description="Deleta um recurso de animê no banco de dados.",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/AnimeInput")
     * ),
     * @OA\Response(
     * response=201,
     * description="O animê foi criado com sucesso.",
     * @OA\JsonContent(ref="#/components/schemas/AnimeOutput")
     * ),
     * @OA\Response(
     * response=422,
     * description="Dados de entrada inválidos.",
     * @OA\JsonContent(ref="#/components/schemas/ValidationError")
     * )
     * )
    */
    public function delete(DestroyAnimeRequest $request, Anime $anime): JsonResponse
    {
        $anime->delete();
        return response()->json(['message'=> 'Anime excluido com sucesso'], 200);
    }

    /**
    * Atualiza um anime existente.
    *
    * @param \Illuminate\Http\Request $request A requisição contendo os dados para atualização. Deve incluir os seguintes campos:
    *      - 'titulo': string, opcional, máximo de 255 caracteres.
    *      - 'genero': string, opcional, máximo de 255 caracteres.
    *      - 'resumo': string, opcional, máximo de 255 caracteres.
    *      - 'episodios': integer, opcional.
    *      - 'lancamento': date, opcional.
    *
    * @return JsonResponse Retorna uma resposta JSON com uma mensagem de sucesso e o recurso atualizado.
    *
    * @throws ValidationException Se os dados de entrada não forem válidos.
    * @throws ModelNotFoundException Se o recurso com o ID fornecido não for encontrado.
    *
    *
    * @OA\Patch(
     * path="/animes",
     * tags={"Animes"},
     * summary="Atualiza um animê",
     * description="Atualiza um recurso de animê no banco de dados.",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/AnimeUpdate")
     * ),
     * @OA\Response(
     * response=201,
     * description="O animê foi criado com sucesso.",
     * @OA\JsonContent(ref="#/components/schemas/AnimeOutput")
     * ),
     * @OA\Response(
     * response=422,
     * description="Dados de entrada inválidos.",
     * @OA\JsonContent(ref="#/components/schemas/ValidationError")
     * )
     * )
    */
    public function update(UpdateAnimeRequest $request, Anime $anime): JsonResponse
    {
        // 1. Autorização (usando Policy)
        // Isso verifica se o usuário autenticado tem permissão para atualizar este anime.
        $this->authorize('update', $anime);

        // 2. Atualização dos dados
        // O método 'validated()' retorna um array com os dados já validados.
        $anime->update($request->validated());

        // 3. Retorno da resposta
        return response()->json($anime);
    }

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
