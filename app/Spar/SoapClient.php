<?php

namespace App\Spar;

use App\Spar\DTO\PersonsokningSvarspost;
use RuntimeException;
use SoapClient as BaseSoapClient;
use SoapFault;

class SoapClient
{
    private BaseSoapClient $client;

    public function __construct()
    {
        try {
            $this->client = new BaseSoapClient(
                config('services.spar.wsdl'),
                [
                    'trace' => true,
                    'exceptions' => true,
                    'local_cert' => storage_path(config('services.spar.cert_path')),
                    'passphrase' => config('services.spar.cert_password'),
                    'stream_context' => stream_context_create([
                        'ssl' => [
                            'verify_peer' => true,
                        ],
                    ]),
                ]
            );
        } catch (SoapFault $e) {
            throw new RuntimeException('Failed to initialize SOAP client: ' . $e->getMessage());
        }
    }

    /**
     * Search for a person in SPAR by their ID number
     *
     * @param  string  $id  The person's ID number (12 digits without dash)
     * @return PersonsokningSvarspost The person's data from SPAR
     *
     * @throws RuntimeException If the SOAP request fails
     */
    public function searchById(string $id)
    {
        try {
            $response = $this->client->PersonSok([
                'Identifieringsinformation' => $this->createIdentification(),
                'PersonsokningFraga' => [
                    'IdNummer' => $id,
                ],
            ]);
        } catch (SoapFault $e) {
            throw new RuntimeException('SOAP request failed: ' . $e->getMessage());
        }

        return PersonsokningSvarspost::from($response->PersonsokningSvarspost);
    }

    private function createIdentification()
    {
        return [
            'KundNrLeveransMottagare' => config('services.spar.kundnrleveransmottagare'),
            'KundNrSlutkund' => config('services.spar.kundnrslutkund'),
            'SlutAnvandarId' => config('services.spar.slutanvandarid'),
            'UppdragId' => config('services.spar.uppdragid'),
        ];
    }
}
