<?php

namespace Database\Factories;

use App\Models\Boatweek;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Boatweek>
 */
class BoatweekFactory extends Factory
{
    protected $model = Boatweek::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = Carbon::instance(fake()->dateTimeBetween('next Saturday', '+6 months'));
        $start->next(Carbon::SATURDAY);
        $end = $start->copy()->addWeek();

        return [
            'week_number' => $end->week,
            'year' => $end->year,
            'start_date' => $start,
            'end_date' => $end,
        ];
    }
}
