<?php

namespace App\Services\Github;

use GuzzleHttp\Client;

class GithubClient
{
    protected const ENDPOINT = 'https://api.github.com/graphql';

    protected $token;

    public function __construct()
    {
        $this->token = config('app.github_api_token');
    }

    protected function loadGraphQLFile($name)
    {
        $path = app_path("Services/Github/graphqls/{$name}.graphql");

        if (!file_exists($path)) {
            throw new Exception('The graphql file does not exist.');
        }

        return trim(file_get_contents($path));
    }

    public function execute($queryName, $variables = [])
    {
        $client = new Client();
        $token = $this->token;

        $response = $client->post(
            static::ENDPOINT,
            [
                'json' => [
                    'query' => $this->loadGraphQLFile($queryName),
                    'variables' => json_encode($variables)
                ],

                'headers' => [
                    'Authorization' => "bearer {$token}",
                ]
            ]
        );

        $result = json_decode($response->getBody()->getContents(), $assoc = true);

        if (! empty($result['errors'])) {
            throw new Exceptions\RequestException(
                json_encode($result['errors'])
            );
        }

        return $result['data'] ?? [];
    }
}
