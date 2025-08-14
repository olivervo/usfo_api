<?php

namespace App\Actions;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\Refund;
use Lorisleiva\Actions\Concerns\AsAction;

class RefundPayment
{
    use AsAction;

    public function handle(Payment $payment, int $amount)
    {
        // TODO: Create refund at Stripe
        // $stripeRefund = $payment->billable->refund($payment->stripe_payment_intent);

        Refund::create([
            'payment_id' => $payment->id,
            'amount' => $amount,
            'stripe_refund_id' => 'WIP',
            'refunded_at' => now(),
        ]);

        $totalRefunded = $payment->refunds->sum('amount');

        if ($payment->balance() - $totalRefunded > 0) {
            $payment->status = PaymentStatus::partially_refunded;
        }

        if ($payment->balance() - $totalRefunded <= 0) {
            $payment->status = PaymentStatus::refunded;
        }

        $payment->save();
    }
}
