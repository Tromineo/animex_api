<?php

namespace App\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="AnimeUpdate",
 * title="AnimeUpdate",
 * description="Dados de entrada para atualizar um anime",
 * required={"title", "genre"},
 * @OA\Property(
 * property="title",
 * type="string",
 * example="Naruto"
 * ),
 * @OA\Property(
 * property="genre",
 * type="string",
 * example="Shonen"
 * )
 * )
 */
class AnimeUpdate
{
}
