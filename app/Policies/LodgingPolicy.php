<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Lodge;
use App\Models\User;

class LodgingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permissions::LodgesView);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lodge $lodge): bool
    {
        return $user->can(Permissions::LodgesView);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permissions::LodgesCreate);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lodge $lodge): bool
    {
        return $user->can(Permissions::LodgesUpdate);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lodge $lodge): bool
    {
        return $user->can(Permissions::LodgesDelete);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lodge $lodge): bool
    {
        return $user->can(Permissions::LodgesUpdate);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lodge $lodge): bool
    {
        return $user->can(Permissions::LodgesDelete);
    }
}
