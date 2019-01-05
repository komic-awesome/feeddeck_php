<?php

namespace App\Services\Github;

use GuzzleHttp\Client;

class GithubService
{
    protected const ENDPOINT = 'https://api.github.com/graphql';

    public static function loadGraphQLFile($name)
    {
        $path = app_path("Services/Github/graphqls/{$name}.graphql");

        if (!file_exists($path)) {
            throw new Exception('The graphql file does not exist.');
        }

        return trim(file_get_contents($path));
    }

    public static function fetchGithubRepository($owner, $name)
    {
        $client = new Client();
        $token = config('app.github_api_token');

        $response = $client->post(
            static::ENDPOINT,
            [
                'json' => [
                    'query' => static::loadGraphQLFile('fetchGithubRepository'),
                    'variables' => json_encode(compact('owner', 'name'))
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
