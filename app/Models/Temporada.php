<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    //hasFactory para permitir a criação de instâncias do modelo para testes e seeders
    use HasFactory;
    //use SoftDeletes para permitir a exclusão lógica de registros, em vez de removê-los permanentemente do banco de dados
    use SoftDeletes;

    protected $table = "temporadas";
    protected $fillable = [
        'anime_id',
        'numero',
        'nome',
        'data_lancamento',
    ];
}
