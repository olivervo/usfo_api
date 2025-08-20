<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Traits\HandlesPagination;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StudentController extends Controller
{
    use HandlesPagination;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Student::class)
            ->allowedFilters([
                AllowedFilter::partial('first_name'),
                AllowedFilter::partial('last_name'),
                AllowedFilter::partial('city'),
                AllowedFilter::exact('sex'),
                AllowedFilter::exact('country'),
            ])
            ->allowedSorts([
                'first_name',
                'last_name',
                'created_at',
            ]);

        $results = $this->paginateOrGet($request, $query);

        return StudentResource::collection($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());

        return new StudentResource($student);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Student $student)
    {
        $student = QueryBuilder::for(Student::where('id', $student->id))
            ->allowedIncludes(['registrations'])
            ->first();

        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // TODO: Implement validation and student update
        // This would typically use a Form Request for validation
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return response()->noContent();
    }
}
