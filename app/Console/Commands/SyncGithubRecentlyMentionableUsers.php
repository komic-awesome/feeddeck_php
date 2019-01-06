<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Github\GithubService;
use App\Models\GithubUser;
use App\Models\GithubRepository;

class SyncGithubRecentlyMentionableUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:github-recently-mentionable-users {owner} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步 github 仓库最新的 mentionable-users';

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
        $owner = $this->argument('owner');
        $name = $this->argument('name');

        $repo = GithubRepository::findOrCreateRepository($owner, $name);
        $repo->syncGithubRecentlyMentionableUsers();
    }
}
