<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Stripe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new Stripe($this->faker));

        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'insass_year' => fake()->numberBetween(2010, Carbon::now()->subYear()->year),
            'DOB' => fake()->personalIdentityNumber(),
            'bank' => fake()->randomElement(['Nordea', 'SEB', 'Handelsbanken', 'Swedbank']),
            'clearing_number' => fake()->numerify('####'),
            'account_number' => fake()->numerify('##########'),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'zipcode' => fake()->postcode(),
            'country' => fake()->countryCode(),
            'allergies' => fake()->optional(0.1)->word(),
            'registry_checked_at' => fake()->optional(0.8)->dateTimeBetween('-5 year', 'now'),
            'user_id' => User::factory(),
            'notes' => fake()->optional(0.1)->paragraph(),
        ];
    }
}
