<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Comentario",
 *     type="object",
 *     title="Comentario",
 *     required={"user_id", "anime_id", "conteudo"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="anime_id", type="integer", example=42),
 *     @OA\Property(property="content", type="string", example="Ótimo anime!"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-28T18:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-28T18:00:00Z")
 * )
 */
class Comentarios extends Model
{
    use HasFactory;

    protected $table = "comments";

    protected $fillable = [
        'user_id',
        'anime_id',
        'content',
    ];
}
