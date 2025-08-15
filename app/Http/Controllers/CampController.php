<?php

namespace App\Http\Controllers;

use App\Traits\HandlesPagination;
use App\Http\Resources\CampResource;
use App\Models\Camp;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CampController extends Controller
{
    use HandlesPagination;

    public function index(Request $request)
    {
        $query = QueryBuilder::for(Camp::published())
            ->allowedFilters([
                AllowedFilter::exact('year'),
                AllowedFilter::exact('age_group'),
                AllowedFilter::exact('camp_category'),
            ]);

        $results = $this->paginateOrGet($request, $query);

        return CampResource::collection($results);
    }

    public function show(Request $request, Camp $camp)
    {
        return $camp->toResource();
    }
}
