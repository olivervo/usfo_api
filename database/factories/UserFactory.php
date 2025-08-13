<?php

namespace Database\Factories;

use Faker\Provider\Stripe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
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
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->e164PhoneNumber(),
            'address_1' => fake()->address(),
            'address_2' => fake()->optional(0.2)->address(),
            'city' => fake()->city(),
            'zipcode' => fake()->postcode(),
            'country' => fake()->countryCode(),
            'id_number' => fake()->personalIdentityNumber(),
            'stripe_id' => fake()->stripeCoreCustomerId(),
            'pm_type' => fake()->randomElement(['visa', 'mastercard', 'amex']),
            'pm_last_four' => fake()->numerify('####'),
            'remember_token' => Str::random(10),
            'avatar' => '',
            'password' => Hash::make('password'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
