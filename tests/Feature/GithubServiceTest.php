<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Github\GithubService;

class GithubServiceTest extends TestCase
{
    const VUE_JS_GITHUB_ID = 'MDEwOlJlcG9zaXRvcnkxMTczMDM0Mg==';

    public function testFetchGithubRepository()
    {
        $service = new GithubService();
        $repository = $service->fetchGithubRepository($owner = 'vuejs', $name = 'vue');

        $this->assertEquals(
            $repository['id'],
            static::VUE_JS_GITHUB_ID
        );
    }

    public function testFetchMentionableUsers()
    {
        $service = new GithubService();

        list(
            $edges,
            $pageInfo,
            $totalCount
        ) = $service->fetchMentionableUsers(
            $owner = 'vuejs',
            $name = 'vue',
            $limit = 1
        );

        $this->assertEquals(
            $pageInfo['hasNextPage'],
            true
        );
    }

    public function testTraverseMentionableUsers()
    {
        $service = new GithubService();
        $service->traverseMentionableUsers(
            $owner = 'komic-awesome',
            $name = 'komic',
            $callback = function ($mentionableUser) {
                $this->assertTrue(
                    in_array(
                        $mentionableUser['login'],
                        [
                            'kyon0304',
                            'hxgdzyuyi'
                        ]
                    )
                );
            },
            $limit = 1
        );
    }
}
