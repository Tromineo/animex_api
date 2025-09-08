<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favoritos extends Model
{
    use HasFactory;

    protected $table = "favorites";

    protected $fillable = [
        'user_id',
        'anime_id',
    ];
}
