<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anime extends Model
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
