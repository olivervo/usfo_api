<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampResource;
use App\Models\Camp;
use App\Traits\HandlesPagination;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CampController extends Controller
{
    use HandlesPagination;

    public function index(Request $request)
    {
        $query = QueryBuilder::for(Camp::class)
            ->allowedFilters([
                AllowedFilter::exact('year'),
                AllowedFilter::exact('age_group'),
                AllowedFilter::exact('camp_category'),
                AllowedFilter::scope('published'),
            ]);

        $results = $this->paginateOrGet($request, $query);

        return CampResource::collection($results);
    }

    public function show(Request $request, Camp $camp)
    {
        $this->authorize('view', $camp);

        $camp = QueryBuilder::for(Camp::where('id', $camp->id))
            ->allowedIncludes(['registrations'])
            ->first();

        return new CampResource($camp);
    }
}
