<?php

namespace App\Http\Controllers\Rss;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GithubRepository;

class GithubRecentlyMentionedChinese extends Controller
{
    public function show(string $owner, string $name)
    {
        $repo = GithubRepository::findOrCreateRepository($owner, $name);

        return [
            'owner' => $repo->owner,
            'name' => $repo->name
        ];
    }
}
