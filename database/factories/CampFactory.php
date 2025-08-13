<?php

namespace Database\Factories;

use App\Models\Camp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Camp>
 */
class CampFactory extends Factory
{
    protected $model = Camp::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('next Saturday', '+6 months');
        $endDate = Carbon::instance($startDate)->addWeeks(rand(1, 4));
        $weeks = Carbon::instance($startDate)->diffInWeeks($endDate);

        return [
            'camp_name' => fake()->randomElement([
                'VK1',
                'VK2',
                'VK3',
                'VG11',
                'VG12',
                'VG21',
                'VG Fortsättning',
                'INS/ASS',
            ]),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'age_group' => fake()->randomElement(['7-9', '10-12', '13-15', '16-18']),
            'camp_category' => fake()->randomElement(['Enveckasläger', 'Tvåveckorsläger', 'Konfirmationsläger', 'Fortsättningsläger', 'INS/ASS']),
            'camp_fee' => fake()->numberBetween(500, 2000),
            'number_males' => fake()->numberBetween(5, 20),
            'number_females' => fake()->numberBetween(5, 20),
            'year' => Carbon::instance($startDate)->year,
            'registration_code' => fake()->optional(0.1)->bothify('??##??'),
            'publish_at' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'weeks' => $weeks,
        ];
    }

    public function unpublished(): self
    {
        return $this->state(fn (array $attributes) => [
            'publish_at' => null,
        ]);
    }

    public function published(): self
    {
        return $this->state(fn (array $attributes) => [
            'publish_at' => now()->subDay(),
        ]);
    }

    public function withRegistrationCode(): self
    {
        return $this->state(fn (array $attributes) => [
            'registration_code' => strtoupper(fake()->bothify('??##??')),
        ]);
    }
}
