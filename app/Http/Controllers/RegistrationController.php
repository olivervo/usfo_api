<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Registration::class);

        return RegistrationResource::collection(Registration::all());
    }

    public function show(Registration $registration)
    {
        $this->authorize('view', $registration);

        return new RegistrationResource($registration);
    }

    public function store(StoreRegistrationRequest $request,
    ): RegistrationResource {
        $registration = Registration::create($request->validated());

        return new RegistrationResource($registration);
    }
}
