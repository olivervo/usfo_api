<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Campsite;
use App\Models\User;

class CampsitePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(Permissions::CampsitesView);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Campsite $campsite): bool
    {
        return $user->can(Permissions::CampsitesView);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permissions::CampsitesCreate);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Campsite $campsite): bool
    {
        return $user->can(Permissions::CampsitesUpdate);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Campsite $campsite): bool
    {
        return $user->can(Permissions::CampsitesDelete);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Campsite $campsite): bool
    {
        return $user->can(Permissions::CampsitesUpdate);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Campsite $campsite): bool
    {
        return $user->can(Permissions::CampsitesDelete);
    }
}
