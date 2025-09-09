<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoritoRequest;
use App\Http\Requests\UpdateFavoritoRequest;
use App\Http\Requests\DeleteFavoritosRequest;
use App\Models\Favoritos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoritosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Favoritos::all());
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
        $favorito = Favoritos::create($request->validated());
        return response()->json($favorito, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return response()->json(Favoritos::find($id));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favoritos $favoritos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favoritos $favoritos)
    {
        //usa policy
        $favoritos->update($request->validated());
        
        return response()->json($favoritos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(DeleteFavoritosRequest $request, Favoritos $favorito)
    {
        //usa policy
        if (!$favorito->exists) {
            return response()->json(['message' => 'Favorito nao encontrado'], 404);
        }

        $favorito->delete();
        return response()->json(null, 204);
    }
}
