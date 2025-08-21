<?php

namespace App\Actions\Spar;

use App\Data\Spar\PersonsokningSvarspost;
use App\Enums\Permissions;
use App\Rules\ValidPersonalId;
use App\Spar\SoapClient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Personnummer\Personnummer;

class SearchSpar
{
    use AsAction;

    public function handle(string $id, bool $cache = true): PersonsokningSvarspost
    {
        // Validate id number
        if(!Personnummer::valid($id)) {
            abort(422, 'Invalid personal id number');
        }

        // Return cached response if enabled
        if ($cache) {
            return cache()->remember(
                'spar_' . hash('sha256', $id),
                now()->addHours(24),
                function () use ($id) {
                    return (new SoapClient)->searchById($id);
                }
            );
        }

        return (new SoapClient)->searchById($id);
    }

    // ActionRequest enables authorize and validate methods
    public function asController(ActionRequest $request): PersonsokningSvarspost
    {
        return $this->handle(
            $request->input('id'),
            $request->boolean('cache', true)
        );
    }

    public function authorize(ActionRequest $request): bool
    {
        return $request->user()?->hasPermissionTo(Permissions::SparSearch->name) ?? false;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'string', new ValidPersonalId],
            'cache' => ['boolean'],
        ];
    }
}
