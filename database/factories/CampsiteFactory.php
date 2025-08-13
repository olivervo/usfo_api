<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campsite>
 */
class CampsiteFactory extends Factory
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
            'price_per_night' => fake()->numberBetween(100, 1000),
        ];
    }
}
