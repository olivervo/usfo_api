<?php

namespace App\Actions\Registrations;

use App\Models\Membership;
use App\Models\Registration;
use Laravel\Cashier\Cashier;
use Lorisleiva\Actions\Concerns\AsAction;
use Stripe\Checkout\Session;

class CreateStripeCheckoutSession
{
    use AsAction;

    public function handle(Registration $registration): Session
    {
        $registration_fee_item = [
            'price_data' => [
                'currency' => 'sek',
                'product_data' => [
                    'name' => 'Anmälningsavgift',
                    'metadata' => [
                        'billable_id' => $registration->id,
                        'billable_type' => Registration::class,
                    ],
                ],
                'unit_amount' => $this->settings->registration_fee * 100,
            ],
            'quantity' => 1,
        ];

        $membership_item = [
            'price_data' => [
                'currency' => 'sek',
                'product_data' => [
                    'name' => 'Medlemsavgift ' . $registration->camp->year,
                    'metadata' => [
                        'billable_id' => $registration->student->memberships->firstWhere('membership_year', $registration->camp->year)->id,
                        'billable_type' => Membership::class,
                    ],
                ],
                'unit_amount' => $this->settings->membership_fee * 100,
            ],
            'quantity' => 1,
        ];

        return Cashier::stripe()->checkout->sessions->create([
            'success_url' => config('app.frontend_url') . '/thankyou?registration_id=' . $registration->id,
            'cancel_url' => config('app.frontend_url') . '/camps/' . $registration->camp->id,
            'line_items' => [
                $registration_fee_item,
                $membership_item,
            ],
            'mode' => 'payment',
            'expires_at' => now()->addminutes(30)->timestamp,
            'customer' => $registration->user->stripeId(),
            'metadata' => [
                'payment_actions' => ['registration_deposit_paid', 'membership_paid'],
                'registration_id' => $registration->id,
                'description' => $registration->first_name . ' ' . $registration->last_name . ' - ' . $registration->camp->name,
            ],
            'payment_intent_data' => [
                'metadata' => [
                    'registration_id' => $registration->id,
                    'student_id' => $registration->student->id,
                    'membership_year' => $registration->camp->year,
                ],
                'description' => $registration->first_name . ' ' . $registration->last_name . ' - ' . $registration->camp->name,
            ],
        ]);
    }
}
