<?php

namespace App\Actions;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;
use Stripe\Customer;

class SyncOrCreateStripeCustomer
{
    use AsAction;

    public function handle(User $user): Customer
    {
        return $user->syncOrCreateStripeCustomer();
    }
}
