<?php

namespace App\Http\Integrator;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class InterBankingIntegrator
{
    protected Client $client;

    protected string $token;

    public function __construct()
    {
        $params = [
            'base_uri' => config('bank.inter.base_url'),
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

    /**
     * @throws GuzzleException
     */
    protected function auth()
    {
        $postfix = 'oauth/v2/token';

        $params = [
            'form_params' => [
                'client_id' => config('bank.inter.client_id'),
                'client_secret' => config('bank.inter.client_secret'),
                'grant_type' => 'client_credentials',
                'scope' => ''
            ]
        ];

        $result = $this->request('POST', $postfix, $params);
    }
}
