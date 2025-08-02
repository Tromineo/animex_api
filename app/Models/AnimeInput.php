<?php
// Exemplo: src/Models/AnimeInput.php
// Ajuste o namespace para o seu projeto

namespace App\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="AnimeInput",
 * title="AnimeInput",
 * description="Dados de entrada para criar um anime",
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
class AnimeInput
{
    // A classe pode ficar vazia ou ter propriedades, mas o Swagger usa a anotação.
}