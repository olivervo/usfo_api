<?php

namespace App\Actions\Spar;

use App\Http\Resources\SparResource;
use App\Spar\DTO\PersonsokningSvarspost;
use App\Spar\SoapClient;
use Illuminate\Http\Request;
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

    public function asController(Request $request): PersonsokningSvarspost
    {
        return $this->handle(
            $request->input('id'),
            $request->boolean('cache', true)
        );
    }
}
