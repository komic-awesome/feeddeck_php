<?php

namespace App\Http\Controllers\Rss;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\GithubRepository;
use Carbon\Carbon;
use DB;

class GithubRecentlyMentionedChinese extends Controller
{
    public function show(string $owner, string $name)
    {
        $repo = GithubRepository::findOrCreateRepository($owner, $name);
        $link = url(
            'rss.github-recently-mentioned-chinese',
            [
                $repo->owner,
                $repo->name
            ]
        );

        $MAX_ITEM = 100;
        $mentionableUsers = $repo
            ->mentionableUsers()
            ->where(function ($query) {
                $query
                    ->where('github_users.location', 'like', "%China%")
                    ->orWhere('github_users.email', 'like', "%qq%");
            })
            ->orderByDesc('pivot_created_at')
            ->orderBy('github_users.id')
            ->take($MAX_ITEM)
            ->get();

        $items = collect($mentionableUsers)->map(function ($user) {
            $name = $user->name ?: $user->login;

            return [
                'title' => $name,
                'link' => $user->url,
                'id' => $user->id_in_github,
                'author' => $name,
                'updated' => $user->pivot->created_at->toIso8601String(),
                'summary' => view(
                    'github-user-summary',
                    [
                        'name' => $name,
                        'email' => $user->email,
                        'location' => $user->location,
                        'avatar_url' => $user->avatar_url,
                        'bio_html' => $user->bio_html,
                        'company_html' => $user->company_html,
                        'website_url' => $user->website_url,
                        'url' => $user->url,
                    ]
                ),
            ];
        });

        $meta = [
            'title' => "{$repo->owner}/{$repo->name} 的社区又出现了新的有趣灵魂",
            'link' => $link,
            'id' => $link,
            'updated' => $items->first()['updated'] ?? Carbon::now()->toIso8601String(),
        ];

        $contents = view('atom', compact('meta', 'items'));

        return new Response($contents, 200, [
            'Content-Type' => 'application/xml;charset=UTF-8',
        ]);
    }
}
