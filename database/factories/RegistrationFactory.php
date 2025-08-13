<?php

namespace Database\Factories;

use App\Models\Camp;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Personnummer\Personnummer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $student = Student::factory()->create();

        $payment = Payment::factory()->create();

        return [
            'camp_id' => Camp::factory(),
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'address_1' => $student->address_1,
            'address_2' => $student->address_2,
            'zipcode' => $student->zipcode,
            'city' => $student->city,
            'country' => $student->country,
            'date_of_birth' => Personnummer::parse($student->id_number)->getDate(),
            'allergies' => $student->allergies,
            'dietary_restrictions' => $student->dietary_restrictions,
            'notes' => fake()->optional(0.1)->sentence(),
            'student_id' => $student->id,
            'user_id' => $payment->user->id,
            'deposit_id' => $payment->id,
            'sex' => $student->sex,
            'status' => 'confirmed',
            'invoice_sent_at' => null,
            'paid_complete' => null,
            'cancelled_at' => null,
        ];
    }

    public function cancelled(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => now()->subDays(rand(1, 30)),
        ]);
    }

    public function pending(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'invoice_sent_at' => null,
            'paid_complete' => null,
            'cancelled_at' => null,
        ]);
    }

    public function forStudent(Student $student): self
    {
        return $this->state(fn (array $attributes) => [
            'student_id' => $student->id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'email' => $student->email,
            'telephone' => $student->telephone,
            'address' => $student->address,
            'zipcode' => $student->zipcode,
            'city' => $student->city,
            'country' => $student->country,
            'DOB' => $student->DOB,
        ]);
    }
}
