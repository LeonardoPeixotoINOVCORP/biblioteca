<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Publisher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn' => fake()->isbn13(),
            'title' => fake()->sentence(3),
            'publisher_id' => Publisher::factory(),
            'bibliography' => fake()->paragraph(),
            'cover' => 'https://picsum.photos/seed/' . fake()->uuid() . '/48/48',
            'price' => fake()->randomFloat(2, 5, 100),
        ];
}
}
