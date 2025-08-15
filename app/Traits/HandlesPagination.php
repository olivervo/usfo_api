<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

trait HandlesPagination
{
    protected function paginateOrGet(Request $request, QueryBuilder $query): Collection|LengthAwarePaginator
    {
        return $request->boolean('paginate', false)
            ? $query->paginate(min($request->integer('per_page', 15), 100))
            : $query->get();
    }
}
