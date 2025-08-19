<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Registration;
use App\Models\Student;
use App\Models\User;

class RegistrationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Registration $registration): bool
    {
        return $user->can(Permissions::RegistrationsView->name);
    }

    /**
     * Determine whether the user can view confidential registration details.
     */
    public function viewDetails(User $user): bool
    {
        return $user->can(Permissions::RegistrationsViewDetails->name);
    }

    /**
     * Determine whether the user can view a registration's financial information.
     */
    public function viewFinances(User $user): bool
    {
        return $user->can(Permissions::RegistrationsViewFinances->name);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Student $student): bool
    {
        if (! $user->students->contains($student)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Registration $registration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Registration $registration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Registration $registration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Registration $registration): bool
    {
        return false;
    }
}
