<?php

namespace App\Policies;

use App\Models\Camp;
use App\Models\User;

class CampPolicy
{
    public function view(?User $user, Camp $camp): bool
    {
        return $camp->isPublished();
    }
}
