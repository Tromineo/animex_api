<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animes>
 */
class AnimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->word(),
            'ano_lancamento' => $this->faker->year(),
            'sinopse' => $this->faker->sentence(),
            'status' => $this->faker->integer(1, 2),
            'url_imagem' => $this->faker->sentence(),
            'genero' => $this->faker->word(),
        ];
    }
}
