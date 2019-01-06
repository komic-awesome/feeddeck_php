<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Github\GithubService;
use App\Models\GithubUser;
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

    public function syncGithubRecentlyMentionableUsers()
    {
        $service = new GithubService();

        $service->traverseMentionableUsers(
            $this->owner,
            $this->name,
            $callback = function ($mentionableUser) {
                $user = GithubUser::firstOrCreate(
                    [
                        'id_in_github' => $mentionableUser['id']
                    ],
                    [
                        'name' => (string) $mentionableUser['name'],
                        'login' => (string) $mentionableUser['login'],
                        'email' => (string) $mentionableUser['email'],
                        'location' => (string) $mentionableUser['location'],
                        'website_url' => (string) $mentionableUser['websiteUrl'],
                        'url' => (string) $mentionableUser['url'],
                        'company' => (string) $mentionableUser['company'],
                        'company_html' => (string) $mentionableUser['companyHTML'],
                        'database_id_in_github' => (string) $mentionableUser['databaseId'],
                        'avatar_url' => (string) $mentionableUser['avatarUrl'],
                        'bio' => (string) $mentionableUser['bio'],
                        'bio_html' => (string) $mentionableUser['bioHTML'],
                    ]
                );

                $this->mentionableUsers()
                     ->syncWithoutDetaching(
                         [ $user->id ]
                     );
            }
        );
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
