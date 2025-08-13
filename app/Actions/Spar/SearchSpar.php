<?php

namespace App\Actions\Spar;

use App\Spar\DTO\PersonsokningSvarspost;
use App\Spar\SoapClient;
use Lorisleiva\Actions\Concerns\AsAction;

class SearchSpar
{
    use AsAction;

    public function handle(string $id, bool $cache = true): PersonsokningSvarspost
    {
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
}
