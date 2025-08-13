<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['name' => 'Ação','slug' => 'acao','description' => ''],
            ['n' => 'Aventura','slug' => 'aventura','description' => ''],
            ['name' => 'Comédia','slug' => 'comedia','description' => ''],
            ['name' => 'Drama', 'slug' => 'drama', 'description' => ''],
            ['name' => 'Fantasia', 'slug' => 'fantasia', 'description' => ''],
            ['name' => 'Musica', 'slug' => 'musica', 'description' => ''],
            ['name' => 'Romance', 'slug' => 'romance', 'description' => ''],
            ['name' => 'Terror', 'slug' => 'terror', 'description' => ''],
            ['name' => 'Ficção Científica', 'slug' => 'ficcao-cientifica', 'description' => ''],
            ['name' => 'Seinen', 'slug' => 'seinen', 'description' => ''],
            ['name' => 'Shoujo', 'slug' => 'shoujo', 'description' => ''],
            ['name' => 'Shounen', 'slug' => 'shounen', 'description' => ''],
            ['name' => 'Slice of Life', 'slug' => 'slice-of-life', 'description' => ''],
            ['name' => 'Sobrenatural', 'slug' => 'sobrenatural', 'description' => ''],
        ];

        Categoria::insert($categorias);
    }
}
