<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncGithubRecentlyMentionableUsers;
use App\Models\GithubRepository;

class SyncAllGithubRecentlyMentionableUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:all-github-recently-mentionable-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步所有 repo 中的最新 mentionableUser';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        GithubRepository::all()->each(function ($repo) {
            SyncGithubRecentlyMentionableUsers::dispatch($repo);
        });
    }
}
