<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Staff;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membership>
 */
class MembershipFactory extends Factory
{
    public function definition(): array
    {
        $memberableTypes = [Student::class, Staff::class];
        $memberableType = fake()->randomElement($memberableTypes);
        $year = Carbon::now()->subYears(fake()->numberBetween(0, 9))->year;

        return [
            'membership_year' => $year,
            'memberable_id' => $memberableType::factory(),
            'memberable_type' => $memberableType,
            'membership_fee' => fake()->randomElement([200, 500]),
            'paid_at' => Carbon::create($year)->addDays(fake()->numberBetween(0, 364)),
            'refunded_at' => null,
            'payment_id' => Payment::factory(),
            'status' => 'paid',
        ];
    }

    public function forYear(int $year): self
    {
        return $this->state(fn (array $attributes) => [
            'membership_year' => $year,
        ]);
    }

    public function forStudent(): self
    {
        return $this->state(fn (array $attributes) => [
            'memberable_id' => Student::factory(),
            'memberable_type' => Student::class,
        ]);
    }

    public function forStaff(): self
    {
        return $this->state(fn (array $attributes) => [
            'memberable_id' => Staff::factory(),
            'memberable_type' => Staff::class,
        ]);
    }

    public function refunded(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'refunded',
            'paid_at' => now()->subDays(rand(31, 60)),
            'refunded_at' => now()->subDays(rand(1, 30)),
            'payment_id' => Payment::factory()->state([
                'status' => 'refunded',
            ]),
        ]);
    }

    public function pending(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'paid_at' => null,
            'refunded_at' => null,
            'payment_id' => null,
        ]);
    }
}
