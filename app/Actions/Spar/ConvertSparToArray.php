<?php

namespace App\Actions\Spar;

use App\Data\PersonsokningSvarspost;
use Lorisleiva\Actions\Concerns\AsAction;

class ConvertSparToArray
{
    use AsAction;

    public function handle(PersonsokningSvarspost $response): array
    {
        $response = $response->toArray();
        $address = $response['Folkbokforingsadress']['SvenskAdress'] ?? [];
        $name = $response['Namn'] ?? [];
        $person = $response['Persondetaljer'] ?? [];

        // Find tilltalsnamn if specified
        if (isset($name['Tilltalsnamn'])) {
            // See SPAR documentation https://www.statenspersonadressregister.se/master/start/teknisk-info/xml-scheman/20231/namn
            $tilltalsnamnPos1 = substr($name['Tilltalsnamn'], 0, 1);
            $tilltalsnamnPos2 = substr($name['Tilltalsnamn'], 1, 1);
            $names = explode(' ', $name['Fornamn']);

            if ($tilltalsnamnPos2 === '0') {
                $firstName = $names[$tilltalsnamnPos1 - 1];
            } else {
                $firstName = $names[$tilltalsnamnPos1 - 1] . ' ' . $names[$tilltalsnamnPos2 - 1];
            }
        } else {
            $firstName = $name['Fornamn'];
        }

        return [
            'first_name' => $firstName ?? null,
            'last_name' => $name['Efternamn'] ?? null,
            'id_number' => $response['PersonId']['IdNummer'],
            'address_1' => $address['Utdelningsadress2'] ?? null,
            'address_2' => $address['Utdelningsadress1'] ?? null,
            'zipcode' => $address['PostNr'] ?? null,
            'city' => ucfirst(strtolower($address['Postort'] ?? null)),
            'country' => $address ? 'SE' : null,
            'sex' => $person['Kon'] ?? null,
            'date_of_birth' => $person['Fodelsedatum'] ?? null,
        ];
    }
}
