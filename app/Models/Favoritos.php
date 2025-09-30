<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="Favorito",
 *     type="object",
 *     title="Favorito",
 *     required={"user_id", "anime_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="anime_id", type="integer", example=42),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-08-28T18:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-08-28T18:00:00Z")
 * )
 */
class Favoritos extends Model
{
    use HasFactory;

    protected $table = "favorites";

    protected $fillable = [
        'user_id',
        'anime_id',
    ];
}
