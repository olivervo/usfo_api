<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __invoke(Request $request): UserResource
    {
        $this->authorize('view', $request->user());

        $user = $request->user();

        // Load roles and permissions for performance
        $user->loadMissing(['roles:id,name', 'permissions:id,name']);

        return new UserResource($user);
    }
}
