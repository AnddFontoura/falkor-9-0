<?php

namespace App\Http\Integrator;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class InterBankingIntegrator
{
    protected Client $client;

    protected string $token;

    public function __construct()
    {
        $params = [
            'cert' => config('bank.inter.certificate'),
            'ssl_key' => config('bank.inter.key'),
            'base_uri' => config('bank.inter.base_url'),
            'Content-Type' => 'application/json',
        ];

        $this->client = new Client($params);
    }

    /**
     * @throws GuzzleException
     */
    protected function request(string $method, string $url, array $options = []): ?string
    {
        $response = $this->client->request($method, $url, $options);

        return $response->getBody()->getContents();
    }

    protected function auth(): void
    {
        $hour = 1000 * 60 * 60;

        $authResponse = Cache::remember('inter_token', $hour, function() {
            $postfix = 'oauth/v2/token';

            $params = [
                'form_params' => [
                    'client_id' => config('bank.inter.client_id'),
                    'client_secret' => config('bank.inter.client_secret'),
                    'grant_type' => 'client_credentials',
                    'scope' => ''
                ]
            ];

            return  $this->request('POST', $postfix, $params);
        });

        $this->token = $authResponse['access_token'];
    }
}
