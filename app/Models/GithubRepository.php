<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Github\GithubService;
use Exception;

class GithubRepository extends Model
{
    protected $guarded = [];

    public function mentionableUsers()
    {
        return $this->belongsToMany(
            'App\Models\GithubUser',
            'github_repository_github_mentionable_user'
        )->withTimestamps();
    }

    public static function findOrCreateRepository($owner, $name)
    {
        $repo = static::firstOrNew(compact('owner', 'name'));

        if (! $repo->exists) {
            $service = new GithubService();
            $repository = $service->fetchGithubRepository($owner, $name);

            if (empty($repository)) {
                throw new Exception('repository is null.');
            }

            $repo->fill([
                'id_in_github' => (string) $repository['id'],
                'description' => (string) $repository['description'],
                'homepage_url' => (string) $repository['homepageUrl'],
                'url' => (string) $repository['url'],
            ])->save();
        }

        return $repo;
    }
}
