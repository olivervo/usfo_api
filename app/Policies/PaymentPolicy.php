<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permissions::PaymentsView);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): bool
    {
        return $user->can(Permissions::PaymentsView) || $payment->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permissions::PaymentsCreate);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payment $payment): bool
    {
        return $user->can(Permissions::PaymentsUpdate);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->can(Permissions::PaymentsDelete);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Payment $payment): bool
    {
        return $user->can(Permissions::PaymentsUpdate);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        return $user->can(Permissions::PaymentsDelete);
    }

    /**
     * Determine whether the user can process payments.
     */
    public function process(User $user): bool
    {
        return $user->can(Permissions::PaymentsProcess);
    }

    /**
     * Determine whether the user can refund payments.
     */
    public function refund(User $user, Payment $payment): bool
    {
        return $user->can(Permissions::PaymentsRefund);
    }
}
