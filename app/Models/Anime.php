<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 * schema="Anime",
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
class Anime extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "animes";

    protected $fillable = [
        'titulo',
        'sinopse',
        'genero',
        'ano_lancamento',
        'url_imagem',
        'status'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
