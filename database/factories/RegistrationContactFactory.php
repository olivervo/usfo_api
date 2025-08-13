<?php

namespace Database\Factories;

use App\Models\Registration;
use App\Models\RegistrationContact;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationContactFactory extends Factory
{
    protected $model = RegistrationContact::class;

    public function definition()
    {
        return [
            'registration_id' => Registration::factory(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_primary' => false,
        ];
    }

    public function primary(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
        ]);
    }
}
