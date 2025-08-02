<?php
// src/Models/AnimeOutput.php

namespace App\Models;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="AnimeOutput",
 * title="Anime Output",
 * description="Dados de um anime retornados pela API",
 * @OA\Property(
 * property="id",
 * type="integer",
 * format="int64",
 * description="ID único do anime",
 * example=123
 * ),
 * @OA\Property(
 * property="title",
 * type="string",
 * description="Título do anime",
 * example="Naruto"
 * ),
 * @OA\Property(
 * property="genre",
 * type="string",
 * description="Gênero do anime",
 * example="Shonen"
 * ),
 * @OA\Property(
 * property="created_at",
 * type="string",
 * format="date-time",
 * description="Data e hora de criação do registro",
 * example="2025-08-02T10:30:00Z"
 * ),
 * @OA\Property(
 * property="updated_at",
 * type="string",
 * format="date-time",
 * description="Data e hora da última atualização do registro",
 * example="2025-08-02T10:30:00Z"
 * )
 * )
 */
class AnimeOutput
{
    // A classe pode ficar vazia, as anotações são o que importa para o Swagger.
}