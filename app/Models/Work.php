<?php

namespace App\Models;

use App\Enums\WorkType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 * schema="Work",
 * title="Work",
 * description="Um trabalho do catálogo",
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
 * @OA\Property(property="type", type="string", enum={"anime", "manga"}, example="anime"),
 * @OA\Property(property="slug", type="string", example="naruto"),
 * @OA\Property(property="episodes", type="integer", nullable=true, example=220),
 * @OA\Property(property="chapters", type="integer", nullable=true, example=700)
 * )
 */
class Work extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'works';

    protected $fillable = [
        'titulo',
        'sinopse',
        'ano_lancamento',
        'url_imagem',
        'id_status',
        'type',
        'slug',
        'episodes',
        'chapters',
    ];

    protected $casts = [
        'type' => WorkType::class,
    ];

    protected $dispatchesEvents = [
        'created' => \App\Events\AnimeCriado::class,
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
