<?php

namespace Database\Factories;

use App\Models\Student;
use Faker\Provider\Stripe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

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
            'id_number' => fake()->personalIdentityNumber(),
            'address_1' => fake()->address(),
            'address_2' => fake()->optional(0.2)->address(),
            'zipcode' => fake()->postcode(),
            'city' => fake()->city(),
            'country' => fake()->countryCode(),
            'date_of_birth' => fake()->date(),
            'sex' => fake()->randomElement(['male', 'female']),
        ];
    }
}
