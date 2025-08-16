<?php

namespace Database\Seeders;

use App\Models\AnimeCategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimeCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Ação'],
            ['nome' => 'Aventura'],
            ['nome' => 'Comédia'],
            ['nome' => 'Drama'],
            ['nome' => 'Fantasia'],
            ['nome' => 'Romance'],
            ['nome' => 'Terror'],
            ['nome' => 'Ficção Científica'],
            ['nome' => 'Slice of Life'],
        ];

        AnimeCategoria::insert($categorias);

    }
}
