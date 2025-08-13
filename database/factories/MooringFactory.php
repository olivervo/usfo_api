<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mooring>
 */
class MooringFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->sentence,
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'capacity' => fake()->numberBetween(1, 10),
            'max_length' => fake()->randomFloat(2, 2, 12),
            'max_draft' => fake()->randomFloat(2, 0.5, 2),
            'max_beam' => fake()->randomFloat(2, 1, 4),
            'price_per_night' => fake()->numberBetween(100, 1000),
        ];
    }
}
