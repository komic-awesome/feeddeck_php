<?php

namespace App\Services\Github;

class GithubService
{
    public static function fetchGithubRepository($owner, $name)
    {
        $client = new GithubClient();

        $response = $client->execute(
            'fetchGithubRepository',
            compact('owner', 'name')
        );

        return $response['repository'] ?? null;
    }

    public static function fetchMentionableUsers($owner, $name, $limit, $after = null)
    {
        $client = new GithubClient();

        $response = $client->execute(
            'fetchMentionableUsers',
            compact('owner', 'name', 'limit', 'after')
        );

        return $response['repository']['mentionableUsers'] ?? null;
    }
}
