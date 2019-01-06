<?php

namespace App\Services\Github;

class GithubService
{
    public function fetchGithubRepository($owner, $name)
    {
        $client = new GithubClient();

        $response = $client->execute(
            'fetchGithubRepository',
            compact('owner', 'name')
        );

        return $response['repository'] ?? null;
    }

    public function fetchMentionableUsers($owner, $name, $limit, $after = null)
    {
        $client = new GithubClient();

        $response = $client->execute(
            'fetchMentionableUsers',
            compact('owner', 'name', 'limit', 'after')
        );

        $result = $response['repository']['mentionableUsers'] ?? [];

        return [
            $result['edges'],
            $result['pageInfo'],
            $result['totalCount']
        ];
    }

    public function traverseMentionableUsers($owner, $name, callable $callback, $limit = 100)
    {
        $hasNextPage = false;
        $after = null;

        do {
            list(
                $edges,
                $pageInfo,
                $totalCount
            ) = $this->fetchMentionableUsers($owner, $name, $limit, $after);

            collect($edges)->pluck('node')->each($callback);

            $hasNextPage = $pageInfo['hasNextPage'];
            $after = $pageInfo['endCursor'];
        } while ($hasNextPage);
    }
}
