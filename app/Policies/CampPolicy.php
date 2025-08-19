<?php

namespace App\Policies;

use App\Enums\Permissions;
use App\Models\Camp;
use App\Models\User;

class CampPolicy
{
    public function view(?User $user, Camp $camp): bool
    {
        if ($user?->can(Permissions::CampsView->name)) {
            return true;
        }

        return $camp->isPublished();
    }
}
