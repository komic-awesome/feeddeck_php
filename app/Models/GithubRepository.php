<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Github\GithubService;
use Exception;

class GithubRepository extends Model
{
    protected $guarded = [];

    public static function findOrCreateRepository($owner, $name)
    {
        $repo = static::firstOrNew(compact('owner', 'name'));

        if (! $repo->exists) {
            $repository = GithubService::fetchGithubRepository($owner, $name);

            if (empty($repository)) {
                throw new Exception('repository is null.');
            }

            $repo->fill([
                'id_in_github' => $repository['id'],
                'description' => $repository['description'],
                'homepage_url' => $repository['homepageUrl'],
                'url' => $repository['url'],
            ])->save();
        }

        return $repo;
    }
}
