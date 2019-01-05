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
        $response = $service->fetchGithubRepository($owner = 'vuejs', $name = 'vue');

        $this->assertEquals(
            $response['repository']['id'],
            static::VUE_JS_GITHUB_ID
        );
    }
}
