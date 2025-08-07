<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 * schema="Animes",
 * title="Anime",
 * description="Um modelo de anime",
 * @OA\Property(
 * property="id",
 * type="integer",
 * example=1
 * ),
 * @OA\Property(
 * property="titulo",
 * type="string",
 * example="Naruto"
 * ),
 * @OA\Property(
 * property="ano",
 * type="integer",
 * example=2002
 * )
 * )
 */
class Animes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "anime";

    protected $fillable = [
        'titulo',
        'resumo',
        'genero',
        'lancamento',
        'episodios'
    ];
}
