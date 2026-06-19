<?php

namespace Database\Factories;

use App\Models\Director;
use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Film>
 */
class FilmFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'release_date' => fake()->date(),
            'sinopsis' => fake()->paragraph(),
            'duration' => fake()->numberBetween(60, 180),
            'gendre' => fake()->randomElement([
                'Accion',
                'Drama',
                'Comedia',
                'Ciencia Ficcion',
            ]),
            'director_id' => Director::factory(),
        ];
    }
}
