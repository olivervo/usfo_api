<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HandlesPagination;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    use HandlesPagination;

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = QueryBuilder::for(User::class)
            ->allowedIncludes(['roles', 'permissions']);

        $results = $this->paginateOrGet($request, $query);

        return UserResource::collection($results);
    }

    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);

        $user->loadMissing(['roles', 'permissions']);

        return new UserResource($user);
    }
}
