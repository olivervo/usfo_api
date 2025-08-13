<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Mooring;
use App\Models\User;

class MooringPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permissions::MooringsView);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mooring $mooring): bool
    {
        return $user->can(Permissions::MooringsView);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permissions::MooringsCreate);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mooring $mooring): bool
    {
        return $user->can(Permissions::MooringsUpdate);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mooring $mooring): bool
    {
        return $user->can(Permissions::MooringsDelete);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Mooring $mooring): bool
    {
        return $user->can(Permissions::MooringsUpdate);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Mooring $mooring): bool
    {
        return $user->can(Permissions::MooringsDelete);
    }
}
