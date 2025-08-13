<?php

namespace Database\Factories;

use App\Models\Lodge;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = now()->addDays(fake()->numberBetween(1, 365));
        $end_date = $start_date->addDays(fake()->numberBetween(1, 10));

        return [
            'user_id' => User::factory(),
            'bookable_id' => Lodge::factory(),
            'bookable_type' => Lodge::class,
            'check_in' => $start_date,
            'check_out' => $end_date,
            'price_paid' => fake()->numberBetween(100, 1000),
        ];
    }
}
