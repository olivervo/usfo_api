<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\User;
use Faker\Provider\Stripe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'user_id' => User::factory(),
            'description' => fake()->sentence(),
            'stripe_checkout_session_id' => fake()->stripeCheckoutSessionId(),
            'stripe_payment_intent' => fake()->stripeCorePaymentIntentId(),
            'amount' => fake()->numberBetween(100, 1000),
            'status' => PaymentStatus::paid,
            'paid_at' => fake()->dateTimeThisYear(),
        ];
    }
}
