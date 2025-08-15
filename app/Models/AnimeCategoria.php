<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 * schema="AnimeCategoria",
 * title="AnimeCategoria",
 * description="Um modelo de categoria de um anime",
 * @OA\Property(
 * property="id",
 * type="integer",
 * example=1
 * ),
 * @OA\Property(
 * property="anime_id",
 * type="integer",
 * example="1"
 * ),
 * @OA\Property(
 * property="categoria_id",
 * type="integer",
 * example=2
 * )
 * )
 */
class AnimeCategoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'anime_categoria';
    protected $fillable = [
        'anime_id',
        'categoria_id',
    ];

    public function animes(){
        return $this->hasMany(Anime::class,'categoria_id');
    }
}
